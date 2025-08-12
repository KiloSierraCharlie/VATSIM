<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Hydration;

use KiloSierraCharlie\VATSIM\Attributes\Mandatory;
use KiloSierraCharlie\VATSIM\Exceptions\InvalidResponseException;
use Psr\Http\Message\ResponseInterface;

class Hydrator
{
    public static function hydrate(string $className, array $data, ?string $originClass = null): object
    {
        if (is_subclass_of($className, HydratableFromArray::class) && $className !== $originClass) {
            $obj = $className::fromArray($data);
            self::validateMandatoryAttributes($obj, $className);

            return $obj;
        }

        $refClass = new \ReflectionClass($className);
        $obj = $refClass->newInstanceWithoutConstructor();
        $defaults = $refClass->getDefaultProperties();

        foreach ($refClass->getProperties() as $prop) {
            $name = $prop->getName();

            $isMandatory = !empty($prop->getAttributes(Mandatory::class));
            if (!array_key_exists($name, $data)) {
                if ($isMandatory) {
                    throw new InvalidResponseException(sprintf('Mandatory property "%s" is missing from API data.', $name));
                }
                continue;
            }

            $value = $data[$name];

            // Attribute-based transforms
            foreach ($prop->getAttributes() as $attr) {
                $inst = $attr->newInstance();
                if (method_exists($inst, 'transform')) {
                    $value = $inst->transform($value);
                }
            }

            $propTypeRef = $prop->getType();
            $propType = $propTypeRef?->getName();

            // Model based hydration:
            if ($propType && class_exists($propType) && (is_subclass_of($propType, HydratableFromArray::class) || is_subclass_of($propType, HydrateFromModel::class))) {
                if (!$value instanceof $propType) {
                    if (null !== $value) {
                        if (!is_array($value)) {
                            throw new \InvalidArgumentException(sprintf('Expected array to hydrate %s for property %s::%s, got %s', $propType, $className, $name, get_debug_type($value)));
                        }
                        $value = self::hydrate($propType, $value, $className);
                    } else {
                        if (!$propTypeRef->allowsNull()) {
                            throw new \InvalidArgumentException(sprintf('Expected array to hydrate %s for property %s::%s, got %s', $propType, $className, $name, get_debug_type($value)));
                        }
                        $value = null;
                    }
                }
            }
            // Scalars
            elseif ('int' === $propType) {
                $value = is_numeric($value) ? (int) $value : null;
            } elseif ('float' === $propType) {
                $value = is_numeric($value) ? (float) $value : null;
            } elseif ('bool' === $propType) {
                $value = is_bool($value) ? $value : in_array($value, [1, '1', true], true);
            } elseif ('string' === $propType) {
                $value = null !== $value ? (string) $value : null;
            }

            if ($propTypeRef && !$propTypeRef->allowsNull() && null === $value) {
                $fallback = $defaults[$name] ?? null;
                if (null === $fallback) {
                    throw new InvalidResponseException(sprintf('Property "%s::%s" is non-nullable but resolved to null.', $className, $name));
                }
                $value = $fallback;
            }

            $prop->setAccessible(true);
            $prop->setValue($obj, $value);
        }

        self::validateMandatoryAttributes($obj, $className);

        return $obj;
    }

    public static function fromResponse(string $className, ResponseInterface $response, ?string $dataPath = null): object
    {
        $data = self::fromJSON($response->getBody()->getContents(), $dataPath);

        return self::hydrate($className, $data);
    }

    public static function fromJSON(string $json, ?string $dataPath = null): array
    {
        $data = json_decode(
            $json,
            true,
            flags: JSON_THROW_ON_ERROR
        );

        if (!is_array($data)) {
            throw new \InvalidArgumentException('JSON did not decode to an array');
        }

        if (null !== $dataPath && !array_key_exists($dataPath, $data)) {
            throw new InvalidResponseException('Response JSON did not decode to an array');
        }

        return $dataPath ? $data[$dataPath] : $data;
    }

    private static function validateMandatoryAttributes(object $obj, string $className): void
    {
        $ref = new \ReflectionObject($obj);

        foreach ($ref->getProperties() as $prop) {
            if (empty($prop->getAttributes(Mandatory::class))) {
                continue;
            }

            if (method_exists($prop, 'isInitialized') && !$prop->isInitialized($obj)) {
                throw new InvalidResponseException(sprintf('Mandatory property "%s::%s" is not initialized.', $className, $prop->getName()));
            }

            $value = $prop->getValue($obj);

            if (null === $value) {
                throw new InvalidResponseException(sprintf('Mandatory property "%s::%s" resolved to null.', $className, $prop->getName()));
            }
        }
    }
}
