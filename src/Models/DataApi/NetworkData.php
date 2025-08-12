<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Models\DataApi;

final class NetworkData
{
    public DataFeed $general;
    public PilotCollection $pilots;
    public ControllerCollection $controllers;
    public ATISCollection $atis;
    public ServerCollection $servers;
    public PrefileCollection $prefiles;
    public FacilityCollection $facilities;
    public RatingCollection $ratings;
    public RatingCollection $pilot_ratings;
    public RatingCollection $military_ratings;
}
