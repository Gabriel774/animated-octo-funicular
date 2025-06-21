<?php

namespace App\Services\Cart\PriceModifiers\CompoundInterest;

use App\Services\Cart\PriceModifiers\Contracts\PriceModifier;

class CompoundInterestModifier implements PriceModifier
{
    public function __construct(
        public float $interestPercentage = 1
    ) {
    }

    public function apply(float $price, array $context = []): float
    {
        $installments = (int) ($context['installments'] ?? 0);

        if ($installments < 1) {
            throw new \InvalidArgumentException('invalid installments');
        }

        $rate = $this->interestPercentage / 100;

        return round($price * pow(1 + $rate, $installments), 2);
    }
}
