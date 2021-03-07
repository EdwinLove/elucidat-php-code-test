<?php

namespace App;

use App\Item;
use App\BasicItem;
use App\MaturingItem;
use App\BackstagePass;
use App\LegendaryItem;
use App\ConjurableItem;
use App\Interfaces\Degrader as Degrades;
use App\Interfaces\Stock;

abstract class Degrader implements Degrades
{
    public static $degradable = true;
    public static $needsToBeSold = true;

    public static function getDegrader(Item $item)
    {
        if (self::hasLegendaryName($item)) {
            $class = LegendaryItem::class;
        } else if (self::hasBackstagePassName($item)) {
            $class = BackstagePass::class;
        } else if (self::hasMaturingName($item)) {
            $class = MaturingItem::class;
        } else if (self::hasConjurableName($item)) {
            $class = ConjurableItem::class;
        } else $class = BasicItem::class;

        return new $class($item);
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

    public static function isDegradable(): bool
    {
        return static::$degradable;
    }

    public static function needsToBeSold(): bool
    {
        return static::$needsToBeSold;
    }

    public $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function __get($name)
    {
        return $this->item->$name;
    }

    public function __set($name, $value)
    {
        $this->item->$name = $value;
    }

    public function isPastSellByDate(): bool
    {
        return $this->sellIn < 0;
    }
}
