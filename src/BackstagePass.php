<?php

namespace App;

use App\Item;
use App\Interfaces\Degrader;
use App\TransientQualityDegrader;
use App\Interfaces\HasTransientQuality;

class BackstagePass extends TransientQualityDegrader implements HasTransientQuality, Degrader
{
    /**
     * TODO - this is temporarily used
     * to determine whether an item should
     * be a backstage pass or not when constructed.
     * 
     * Ideally, we'd have some properties & logic in the Item class
     * for this, or we'd just instantiate BackstagePasses from the get-go,
     * but the Goblin is stopping doing the former and I'm not sure
     * what the protocol is regarding editing the existing tests!
     */
    public static $names = [
        'Backstage passes to a TAFKAL80ETC concert',
    ];

    /**
     * A backstage pass can change quality when:
     * 
     * - Concert has not yet passed
     * - Degraded quality is less than 50
     */
    public function canDegradeFurther(Item $item): bool
    {
        return !$this->isPastSellByDate($item) && $item->quality - $this->getDegradationAmount($item) < 50;
    }

    /**
     * A backstage pass increases in quality the closer
     * it gets to the date of the concert.
     * 
     * - When 10 or more days remaining, increase quality by 1
     * - When 5-9 days remaining, increase quality by 2
     * - When 0-4 days remaining, increase quality by 3
     * - Otherwise, do not change quality - note this is 
     *   just a fallback. Quality of an expired backstage
     *   pass is always 0.
     */
    public function getStandardDegradationAmount(Item $item): int
    {
        if($item->sellIn >= 10) return -1;

        if($item->sellIn >= 5) return -2;

        if($item->sellIn >= 0) return -3;

        return 0;
    }

    /**
     * Once the concert has passed, a backstage
     * pass loses all of its quality/value
     */
    public function getPostSellByDateDegradationAmount(Item $item): int
    {
        return $item->quality;
    }

    public function getMaximisedDegredation(Item $item): int
    {
        return $this->isPastSellByDate($item) ? self::$minQuality : self::$maxQuality;
    }
}
