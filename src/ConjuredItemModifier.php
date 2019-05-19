<?php

namespace App;

class ConjuredItemModifier
{
    public function nextDay(Item $item)
    {
        if ($item->quality > 1) {
            $item->quality = $item->quality - 2;
        }
        $item->sellIn = $item->sellIn - 1;
        if ($item->sellIn < 0) {
            if ($item->quality > 1) {
                $item->quality = $item->quality - 2;
            }
        }
    }
}
