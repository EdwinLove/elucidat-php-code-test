<?php

namespace App;

use App\ItemModifier;

class GildedRose
{
    private $items;
    private $itemModifier;

    public function __construct(array $items)
    {
        $this->items = $items;
        $this->itemModifier = new ItemModifier();
    }

    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]
        );
    }

    public function nextDay()
    {
        foreach ($this->items as $item) {
            $this->itemModifier->nextDay($item);
        }
    }
}
