<?php

if (!function_exists('truncateFloat')) {
    function truncateFloat(float $value, int $decimals = 2): float
    {
        $value = (string) $value;

        if (strpos($value, '.') === false) {
            return (float) ($value . ($decimals > 0 ? ('.' . str_repeat('0', $decimals)) : ''));
        }

        list($int, $dec) = explode('.', $value, 2);

        $truncated = $int . '.' . substr($dec . str_repeat('0', $decimals), 0, $decimals);

        return (float) rtrim($truncated, '.');
    }
}
