<?php

namespace App;

class GildedRose
{
    private $items;
    private $itemModifiers;

    public function __construct(array $items)
    {
        $this->items = $items;
        $this->itemModifiers = [
            'Aged Brie' => new AgedBrieModifier(),
            'Sulfuras, Hand of Ragnaros' => new SulfurasModifier(),
            'Backstage passes to a TAFKAL80ETC concert' => new BackstagePassModifier(),
            'Conjured Mana Cake' => new ConjuredItemModifier(),
            'default' => new ItemModifier(),
        ];
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
        if (isset($this->itemModifiers[$item->name])) {
            return $this->itemModifiers[$item->name];
        }
        
        return $this->itemModifiers['default'];
    }
}
