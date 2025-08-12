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

final class Pilot extends HydrateFromModel
{
    public int $cid;
    public string $name;
    public string $callsign;
    public string $server;
    public int $pilot_rating;
    public int $military_rating;
    public float $latitude;
    public float $longitude;
    public int $altitude;
    public int $groundspeed;
    public string $transponder;
    public int $heading;
    public int $qnh_i_hg;
    public int $qnh_mb;
    public ?FlightPlan $flight_plan = null;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $last_updated = null;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $logon_time = null;
}
