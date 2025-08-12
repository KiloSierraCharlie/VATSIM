<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models;
use KiloSierraCharlie\VATSIM\Hydration\HydratableFromArray;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;

final class AirportCollection extends HydratableFromArray
{
    protected static function targetClass(): string 
    {
        return Airport::class;
    }

    /** @var Event[] */
    public array $airports = [];

    public function __construct(Airport ...$airports)
    {
        $this->airports = $airports;
    }

    /** @return Event[] */
    public function all(): array
    {
        return $this->airports;
    }
}