<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\DataApi;

use KiloSierraCharlie\VATSIM\Hydration\HydrateFromModel;

final class Rating extends HydrateFromModel
{
    public int $id;
    public string $short_name;
    public string $long_name;
}
