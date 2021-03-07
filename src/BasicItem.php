<?php

namespace App;

use App\Interfaces\Stock;
use App\TransientQualityItem;
use App\Interfaces\HasTransientQuality;

class BasicItem extends TransientQualityItem implements Stock, HasTransientQuality
{
    /**
     * A basic item can degrade as long
     * as it has a quality greater than or equal to
     * however much it should degrade based on its
     * sellIn
     */
    public function canFurtherDegrade(): bool
    {
        return $this->quality >= $this->getDegradationAmount();
    }
}
