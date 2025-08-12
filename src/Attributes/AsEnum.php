<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class AsEnum
{
    public function __construct(
        public string $enumClass,
        public ?object $default = null,
    ) {
        if (!enum_exists($enumClass)) {
            throw new \InvalidArgumentException("{$enumClass} is not a valid enum.");
        }
    }

    public function transform(mixed $value): ?object
    {
        if (null === $value) {
            return $this->default;
        }

        try {
            return ($this->enumClass)::from($value);
        } catch (\ValueError) {
            return $this->default;
        }
    }
}
