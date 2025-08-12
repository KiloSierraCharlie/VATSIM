<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\DataApi;

final class Transciever
{
    public int $id;
    public int $frequency;
    public float $latDeg;
    public float $lonDeg;
    public int $heightMslM;
    public int $heightAglM;

    public function getFrequency(): string
    {
        return rtrim(rtrim(number_format($this->frequency / 1_000_000, 6, '.', ''), '0'), '.');
    }
}
