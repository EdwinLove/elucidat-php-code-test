<?php

namespace App\Interfaces;

interface Stock {
    public static function isDegradable(): bool;
    public static function needsToBeSold(): bool;
}