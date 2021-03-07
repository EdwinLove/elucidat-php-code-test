<?php

namespace App;

use App\Interfaces\Stock;
use App\TransientQualityItem;
use App\Interfaces\HasTransientQuality;

class BasicItem extends TransientQualityItem implements Stock, HasTransientQuality
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
