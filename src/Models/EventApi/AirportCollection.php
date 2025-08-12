<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\EventApi;

use KiloSierraCharlie\VATSIM\Hydration\HydratableFromArray;

final class AirportCollection extends HydratableFromArray
{
    protected static function targetClass(): string
    {
        return Airport::class;
    }
}
