<?php

namespace App\Services\Cart\PriceModifiers\Contracts;

interface PriceModifier
{
    public function apply(float $price, array $context = []): float;
}
