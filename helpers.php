<?php

if (!function_exists('float2DecimalPlaces')) {
    function float2DecimalPlaces($value): float
    {
        return floatval(preg_replace("/[^-0-9\.]/", "", number_format($value, 2)));
    }
}

if (!function_exists('app')) {
    function app(): \App\App
    {
        return \App\App::get();
    }
}
