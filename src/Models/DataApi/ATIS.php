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
use KiloSierraCharlie\VATSIM\Enums\ControllerRating;

final class ATIS
{
    public int $cid;
    public string $name;
    public ?string $real_name = null;
    public string $callsign;
    public string $frequency;
    public int $facility;
    public ControllerRating $rating;
    public float $latitude;
    public float $longitude;
    public string $server;
    public int $visual_range;
    public ?string $atis_code = null;
    public ?array $text_atis = null;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $last_updated = null;
    #[AsDate(format: 'Y-m-d\TH:i:s.u\Z', timezone: 'UTC')]
    public ?\DateTimeImmutable $logon_time = null;
}
