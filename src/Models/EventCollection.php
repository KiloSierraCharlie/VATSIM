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

final class EventCollection extends HydratableFromArray
{
    protected static function targetClass(): string 
    {
        return Event::class;
    }

    /** @var Event[] */
    public array $events = [];

    public function __construct(Event ...$events)
    {
        $this->events = $events;
    }

    /** @return Event[] */
    public function all(): array
    {
        return $this->events;
    }
}