<?php

namespace App;

use App\Item;
use App\Interfaces\Degrader;
use App\TransientQualityDegrader;
use App\Interfaces\HasTransientQuality;

class BasicItem extends TransientQualityDegrader implements HasTransientQuality, Degrader
{
    /**
     * A basic item degrades until
     * quality hits 0
     */
    public function getMaximisedDegredation(): int
    {
        return self::$minQuality;
    }
}
