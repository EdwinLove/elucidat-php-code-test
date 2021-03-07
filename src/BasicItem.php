<?php

namespace App;

use App\Interfaces\Stock;
use App\TransientQualityItem;
use App\Interfaces\HasTransientQuality;

class BasicItem extends TransientQualityItem implements Stock, HasTransientQuality
{
    // 
}
