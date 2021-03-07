<?php

namespace App;

use App\Item;
use App\BasicItem;
use App\MaturingItem;
use App\BackstagePass;
use App\LegendaryItem;
use App\ConjurableItem;
use App\Interfaces\Stock;

abstract class StockItem extends Item implements Stock
{
    public static $degradable = true;

    /**
     * TODO - Slightly awkward constructor to instantiate our
     * specific type of item using data from the original
     * item
     * 
     * This wouldn't be necessary if we could vary the type
     * we're passing in the existing tests, but I'll assume
     * that isn't allowed!
     */
    public function __construct(Item $item)
    {
        parent::__construct($item->name, $item->quality, $item->sellIn);
    }

    /**
     * TODO - these hasXXXXXXName methods are only necessary
     * as we can't touch the Item class or (presumably)
     * the existing tests.
     * 
     * Ideally, we'd have an itemType property for an item
     * which would allow us to more easily instantiate
     * the right class or adjust our logic accordingly
     */
    public static function hasLegendaryName(Item $item)
    {
        return in_array($item->name, LegendaryItem::$names);
    }

    public static function hasMaturingName(Item $item)
    {
        return in_array($item->name, MaturingItem::$names);
    }

    public static function hasConjurableName(Item $item)
    {
        return in_array($item->name, ConjurableItem::$names);
    }

    public static function hasBackstagePassName(Item $item)
    {
        return in_array($item->name, BackstagePass::$names);
    }

    /**
     * TODO - an artifact of not being able to
     * have an itemType property of Item.
     * 
     * We'll no longer need this if we can
     * sweet talk the Goblin
     */
    public static function getType(Item $item): string
    {
        if (self::hasLegendaryName($item)) {
            return LegendaryItem::class;
        } else if (self::hasBackstagePassName($item)) {
            return BackstagePass::class;
        } else if (self::hasMaturingName($item)) {
            return MaturingItem::class;
        } else if (self::hasConjurableName($item)) {
            return ConjurableItem::class;
        } else return BasicItem::class;
    }

    public static function isDegradable(): bool
    {
        return self::$degradable;
    }

    public function isPastSellByDate(): bool
    {
        return $this->sellIn < 0;
    }
}
