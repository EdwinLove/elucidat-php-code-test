<?php

namespace App\Interfaces;

interface HasTransientQuality
{
    public function degrade(): HasTransientQuality;
    public function canDegradeFurther(): bool;
    public function getMaximisedDegredation(): int;
    public function getDegradationAmount(): int;
    public function getPostSellByDateDegradationAmount(): int;
    public function getStandardDegradationAmount(): int;
}
