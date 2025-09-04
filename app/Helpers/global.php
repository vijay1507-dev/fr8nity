<?php

use Carbon\Carbon;

if (! function_exists('utcNow')) {
    function utcNow(): Carbon
    {
        return Carbon::now('UTC');
    }
}
