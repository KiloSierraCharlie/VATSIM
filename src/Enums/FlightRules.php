<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Enums;

enum FlightRules: string
{
    case IFR = 'I';
    case VFR = 'V';
    case UNKNOWN = '';
}
