<?php

namespace App;

use App\Interfaces\Degrader;
use App\Degrader as BaseDegrader;

abstract class StaticQualityItem extends BaseDegrader implements Degrader
{
    /**
     * Static quality items do not degrade
     */
    public static $degradable = false;
}
