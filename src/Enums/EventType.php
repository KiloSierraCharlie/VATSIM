<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Enums;

enum EventType: string
{
    case EVENT = 'Event';
    case EXAM = 'Controller Examination';
    case VASOPS = 'VASOPS Event';
    case UNKNOWN = 'Unknown';
}