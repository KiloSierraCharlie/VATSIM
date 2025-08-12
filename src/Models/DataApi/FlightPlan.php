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
use KiloSierraCharlie\VATSIM\Enums\FlightRules;
use KiloSierraCharlie\VATSIM\Attributes\AsEnum;

final class FlightPlan extends HydrateFromModel
{
    #[AsEnum(enumClass: FlightRules::class, default: FlightRules::UNKNOWN)]
    public FlightRules $flight_rules;
    public string $aircraft;
    public string $aircraft_faa;
    public string $aircraft_short;
    public string $departure;
    public string $arrival;
    public string $alternate;
    #[AsDate(format: 'Hi', timezone: 'UTC')]
    public ?\DateTimeImmutable $deptime = null;
    #[AsDate(format: 'Hi', timezone: 'UTC')]
    public ?\DateTimeImmutable $enroute_time = null;
    #[AsDate(format: 'Hi', timezone: 'UTC')]
    public ?\DateTimeImmutable $fuel_time = null;
    public string $remarks;
    public string $route;
    public int $revision_id;
    public string $assigned_transponder;
}
