<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\DataApi;

final class Server
{
    public string $ident;
    public string $hostname_or_ip;
    public string $location;
    public string $name;
    public bool $client_connections_allowed;
    public bool $is_sweatbox;
}
