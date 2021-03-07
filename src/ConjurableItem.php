<?php

namespace App;

use App\Interfaces\Stock;
use App\TransientQualityItem;
use App\Interfaces\HasTransientQuality;

class ConjurableItem extends TransientQualityItem implements Stock, HasTransientQuality
{
    /**
     * TODO - this is temporarily used
     * to determine whether an item should
     * be a conjurable item or not when constructed.
     * 
     * Ideally, we'd have some properties & logic in the Item class
     * for this, or we'd just instantiate ConjurableItems from the get-go,
     * but the Goblin is stopping doing the former and I'm not sure
     * what the protocol is regarding editing the existing tests!
     */
    public static $names = [
        'Conjured Mana Cake',
    ];

    /**
     * Conjurable items degrade twice
     * as fast as normal items
     */
    protected $standardDegradationAmount = 2;
}
