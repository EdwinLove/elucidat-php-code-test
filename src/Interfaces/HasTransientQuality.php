<?php

namespace App\Interfaces;

use App\Item;

interface HasTransientQuality
{
    public function degrade(Item $item): Item;
    public function canDegradeFurther(Item $item): bool;
    public function getMaximisedDegredation(Item $item): int;
    public function getDegradationAmount(Item $item): int;
    public function getPostSellByDateDegradationAmount(Item $item): int;
    public function getStandardDegradationAmount(Item $item): int;
}
