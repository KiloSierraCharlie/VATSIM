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
use KiloSierraCharlie\VATSIM\Attributes\AsEnum;
use KiloSierraCharlie\VATSIM\Enums\ControllerRating;

final class Controller
{
    public int $cid;
    public string $name;
    public string $callsign;
    public string $frequency;
    #[AsEnum(enumClass: ControllerRating::class)]
    public ControllerRating $rating;
    public string $server;
    public int $visual_range;
    public ?array $text_atis = null;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $last_updated = null;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $logon_time = null;
}
