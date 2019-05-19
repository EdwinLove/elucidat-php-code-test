<?php

namespace App;

use App\ItemModifier;

class GildedRose
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
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
            $this->getItemModifier($item)->nextDay($item);
        }
    }

    private function getItemModifier(Item $item)
    {
        return new ItemModifier();
    }
}
