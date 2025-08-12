<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\DataApi;

use KiloSierraCharlie\VATSIM\Attributes\AsDate;
use KiloSierraCharlie\VATSIM\Hydration\HydrateFromModel;

final class DataFeed extends HydrateFromModel
{
    public int $version;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $update_timestamp = null;
    public int $connected_clients;
    public int $unique_users;
}
