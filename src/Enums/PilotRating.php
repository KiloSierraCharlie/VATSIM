<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Enums;

enum PilotRating: int
{
    case P0 = 0;
    case PPL = 1;
    case IR = 3;
    case CMEL = 7;
    case ATPL = 15;
    case FI = 31;
    case FE = 63;
}
