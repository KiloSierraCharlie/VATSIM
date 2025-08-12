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

final class Prefile
{
    public int $cid;
    public string $name;
    public string $callsign;
    public FlightPlan $flight_plan;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $last_updated = null;
}
