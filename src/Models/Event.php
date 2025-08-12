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
use KiloSierraCharlie\VATSIM\Attributes\AsEnum;
use KiloSierraCharlie\VATSIM\Attributes\Mandatory;
use KiloSierraCharlie\VATSIM\Exceptions\InvalidResponseException;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;

enum EventType:string {
    case EVENT = "Event";
    case EXAM = "Controller Examination";
    case VASOPS = "VASOPS Event";
    case UNKNOWN = "Unknown";
}

final class Event
{
    public int $id;
    
    #[AsEnum(enumClass: EventType::class, default: EventType::UNKNOWN)]
    public EventType $type;

    public string $name;

    public string $link;

    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public \DateTimeImmutable $start_time;

    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public \DateTimeImmutable $end_time;

    public OrganiserCollection $organisers;

    public AirportCollection $airports;

    public RouteCollection $routes;
        
    public string $short_description;

    public string $description;
    
    public string $banner;
}