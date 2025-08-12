<?php
/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace KiloSierraCharlie\VATSIM\Hydration;

abstract class HydratableFromArray
{
    protected static function targetClass(): string 
    {
        return static::class;
    }    

    public static function fromArray(array $data): static
    {
        $items = array_map(
            static fn(array $row) => Hydrator::hydrate(static::targetClass(), $row),
            $data
        );
        return new static(...$items);
    }
}