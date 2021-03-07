<?php

namespace App;

use App\Interfaces\Stock;
use App\StaticQualityItem;

class LegendaryItem extends StaticQualityItem implements Stock
{
    public static $needsToBeSold = false;

    /**
     * TODO - this is temporarily used
     * to determine whether an item should
     * be a legendary item or not when constructed.
     * 
     * Ideally, we'd have some properties & logic in the Item class
     * for this, or we'd just instantiate LegendaryItems from the get-go,
     * but the Goblin is stopping doing the former and I'm not sure
     * what the protocol is regarding editing the existing tests!
     */
    public static $names = [
        'Sulfuras, Hand of Ragnaros'
    ];
}
