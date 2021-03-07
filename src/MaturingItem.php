<?php

namespace App;

use App\Interfaces\Stock;
use App\Interfaces\HasTransientQuality;


class MaturingItem extends TransientQualityItem implements Stock, HasTransientQuality
{
    /**
     * TODO - this is temporarily used
     * to determine whether an item should
     * be a maturing item or not when constructed.
     * 
     * Ideally, we'd have some properties & logic in the Item class
     * for this, or we'd just instantiate MaturingItems from the get-go,
     * but the Goblin is stopping doing the former and I'm not sure
     * what the protocol is regarding editing the existing tests!
     */
    public static $names = [
        'Aged Brie'
    ];

    /**
     * Maturing items increase in quality
     * as time goes on, so they have a negative
     * degradation amount.
     */
    protected $standardDegradationAmount = -1;

    /**
     * The degradation behaviour for maturing items does not
     * change after the sell-by date.
     */
    public function getPostSellByDateDegradationAmount(): int
    {
        return $this->getStandardDegradationAmount();
    }

    /**
     * A maturing item can further increase in quality when:
     * 
     * - Quality is less than 50
     */
    public function canFurtherDegrade(): bool
    {
        return $this->quality < 50;
    }
}
