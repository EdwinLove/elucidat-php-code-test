<?php

namespace App\Interfaces;

interface Degrader
{
    public static function isDegradable(): bool;
    public static function needsToBeSold(): bool;
}
