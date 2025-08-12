<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\MetarApi;

use KiloSierraCharlie\VATSIM\Hydration\HydratableFromArray;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;

final class MetarCollection extends HydratableFromArray
{
    protected static function targetClass(): string
    {
        return Metar::class;
    }

    public static function fromArray(array $data): static
    {
        $clean = array_values(array_filter(array_map(
            static fn ($v) => is_string($v) ? trim($v) : $v,
            $data
        ), static fn ($v) => is_string($v) && '' !== $v));

        $metars = array_map(
            static fn (string $line) => Hydrator::hydrate(Metar::class, ['raw' => $line]),
            $clean
        );

        return new static(...$metars);
    }
}
