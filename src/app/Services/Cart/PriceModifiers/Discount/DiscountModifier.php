<?php

namespace App\Services\Cart\PriceModifiers\Discount;

use App\Services\Cart\PriceModifiers\Contracts\PriceModifier;

class DiscountModifier implements PriceModifier
{
    public function __construct(
        public float $value,
        public DiscountType $type = DiscountType::PERCENTAGE
    ) {
    }

    public function apply(float $price, array $context = []): float
    {
        return round(match ($this->type) {
            DiscountType::PERCENTAGE => $price * (1 - $this->value / 100),
            DiscountType::FIXED => max(0, $price - $this->value),
        }, 2);
    }
}
