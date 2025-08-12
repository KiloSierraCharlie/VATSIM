<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Enums;

enum ServerType: string
{
    case ALL = 'all-servers.json';
    case SWEATBOX = 'sweatbox-servers.json';
    case NETWORK = 'vatsim-servers.json';
}
