<?php

namespace App\Interfaces;

interface HasTransientQuality
{
    public function degrade(): HasTransientQuality;
    public function canFurtherDegrade(): bool;
    public function getMaximisedDegredation(): int;
    public function getDegradationAmount(): int;
    public function getPostSellByDateDegradationAmount(): int;
    public function getStandardDegradationAmount(): int;
}
