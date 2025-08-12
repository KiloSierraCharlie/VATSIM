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

final class OrganiserCollection extends HydratableFromArray
{
    protected static function targetClass(): string 
    {
        return Organiser::class;
    }

    /** @var Organiser[] */
    public array $organisers = [];

    public function __construct(Organiser ...$organisers)
    {
        $this->organisers = $organisers;
    }

    /** @return Organiser[] */
    public function all(): array
    {
        return $this->organisers;
    }
}