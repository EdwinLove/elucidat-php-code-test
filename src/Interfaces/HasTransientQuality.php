<?php

namespace App\Interfaces;

interface HasTransientQuality
{
    public function degrade(): HasTransientQuality;
    public function canFurtherDegrade(): bool;
    public function getDegradationAmount(): int;
    public function getMaxPossibleDegradationAmount(): int;
    public function getPostSellByDateDegradationAmount(): int;
    public function getStandardDegradationAmount(): int;
}
