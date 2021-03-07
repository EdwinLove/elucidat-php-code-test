<?php

namespace App;

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
    private $items = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $className = StockItem::getType($item);

            array_push($this->items, new $className($item));
        }
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
            if ($item->needsToBeSold()) {
                $item->sellIn = $item->sellIn - 1;
            }


            if ($item->isDegradable()) {
                $item->degrade();
            }
        }
    }
}
