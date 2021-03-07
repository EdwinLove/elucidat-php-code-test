<?php

namespace App;

use App\Degrader;
use App\StockItem;

/**
 * TODO - have a quiet word with the Goblin and see how he'd
 * feel about letting us make some tweaks to the Item class.
 * 
 * It'd make the codebase a bit tidier!
 * 
 * I've had to add some slightly awkward extensions
 * of the item class and logic in the GildedRose class
 * to get around this for now!
 */

class GildedRose
{
    private $items;

    public function __construct(array $items)
    {
        /**
         * We'll associate the appropriate degrader with 
         * the item at this point. If this isn't allowed,
         * we could just as easily run the getDegrader
         * method every time we need it, but it wouldn't be
         * very efficient.
         */
        $this->items = array_map(function($item){
            $item->degrader = Degrader::getDegrader($item);
            return $item;
        }, $items);
    }

    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]);
    }

    public function nextDay()
    {
        foreach ($this->items as $item) {

            /**
             * We only need to decrement sellIn
             * if the item needs to be sold
             */
            if ($item->degrader->needsToBeSold()) {
                $item->sellIn--;
            }

            /**
             * We only need to degrade degradable items
             */
            if ($item->degrader->isDegradable()) {
                $item->degrader->degrade($item);
            }
        }
    }
}
