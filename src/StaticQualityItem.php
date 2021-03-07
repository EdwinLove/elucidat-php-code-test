<?php

namespace App;

use App\StockItem;
use App\Interfaces\Stock;

abstract class StaticQualityItem extends StockItem implements Stock
{
    /**
     * Static quality items do not degrade
     */
    public static $degradable = false;
}
