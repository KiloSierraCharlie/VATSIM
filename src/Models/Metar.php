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
use KiloSierraCharlie\VATSIM\Attributes\Mandatory;
use KiloSierraCharlie\VATSIM\Exceptions\InvalidResponseException;
use KiloSierraCharlie\VATSIM\Hydration\HydratableFromArray;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;

final class Metar extends HydratableFromArray
{
    #[Mandatory]
    public string $icao;

    #[Mandatory]
    #[AsDate(format: 'dHi\Z', timezone: 'UTC')]
    public \DateTimeImmutable $observationTime;

    public string $data;

    public string $raw;

    public static function fromArray(array $data): static
    {
        $raw = $data['raw'] ?? null;
        if (!is_string($raw) || '' === trim($raw)) {
            throw new InvalidResponseException('Metar requires a non-empty raw string');
        }

        [$icao, $observationTime, $data] = preg_split('/\s+/', trim($raw), 3) + [null, null, ''];

        if (!is_string($icao) || !preg_match('/^[A-Z]{4}$/', $icao)) {
            throw new InvalidResponseException("Invalid ICAO in Metar: {$raw}");
        }

        if (!is_string($observationTime) || !preg_match('/^\d{6}Z$/', $observationTime)) {
            throw new InvalidResponseException("Invalid observation time in Metar: {$observationTime}");
        }

        return Hydrator::hydrate(static::class, [
            'icao' => $icao,
            'observationTime' => $observationTime,
            'data' => $data,
            'raw' => $raw,
        ], static::class);
    }
}
