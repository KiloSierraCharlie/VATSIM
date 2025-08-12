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

final class RouteCollection extends HydratableFromArray
{
    protected static function targetClass(): string 
    {
        return Route::class;
    }

    /** @var Route[] */
    public array $routes = [];

    public function __construct(Route ...$routes)
    {
        $this->routes = $routes;
    }

    /** @return Route[] */
    public function all(): array
    {
        return $this->routes;
    }
}