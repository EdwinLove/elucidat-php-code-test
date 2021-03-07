<?php

namespace App;

use App\Interfaces\Degrader;
use App\Degrader as BaseDegrader;
use App\Interfaces\HasTransientQuality;

abstract class TransientQualityDegrader extends BaseDegrader implements HasTransientQuality, Degrader
{
    public static $minQuality = 0;
    public static $maxQuality = 50;

    /**
     * Transient quality items degrade
     */
    public static $degradable = true;

    /**
     * The default amount for a transient
     * quality item to degrade per day is 1
     */
    protected $standardDegradationAmount = 1;

    /**
     * Perform degradation.
     * 
     * Remove the appropriate amount of quality from
     * the item.
     * 
     * Improving quality can be accounted for with
     * negative degradation values.
     */
    public function degrade(): HasTransientQuality
    {
        if ($this->canDegradeFurther()) {
            $this->quality = $this->quality - $this->getDegradationAmount();
        } else {
            $this->quality = $this->getMaximisedDegredation();
        }

        return $this;
    }

    /**
     * A transient quality item can degrade as long
     * as it has a quality greater than or equal to
     * however much it should degrade based on its
     * sellIn
     */
    public function canDegradeFurther(): bool
    {
        return $this->quality >= $this->getDegradationAmount();
    }

    /**
     * Get the standard amount an item should degrade
     * by when the sell-by has not passed
     */
    public function getStandardDegradationAmount(): int
    {
        return $this->standardDegradationAmount;
    }

    /**
     * Get the amount an item should degrade by when the
     * sell-by has passed (twice as fast as normal)
     */
    public function getPostSellByDateDegradationAmount(): int
    {
        return $this->getStandardDegradationAmount() * 2;
    }

    /**
     * Based on whether the sell-by has passed,
     * get the amount an item should degrade by
     */
    public function getDegradationAmount(): int
    {
        return $this->isPastSellByDate() ?
            $this->getPostSellByDateDegradationAmount() :
            $this->getStandardDegradationAmount();
    }
}
