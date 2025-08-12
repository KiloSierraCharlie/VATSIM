<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models;
use KiloSierraCharlie\VATSIM\Attributes\AsDate;
use KiloSierraCharlie\VATSIM\Attributes\Mandatory;
use KiloSierraCharlie\VATSIM\Exceptions\InvalidResponseException;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;
use KiloSierraCharlie\VATSIM\Hydration\HydratableFromArray;

final class Airport
{
    public string $icao;

}