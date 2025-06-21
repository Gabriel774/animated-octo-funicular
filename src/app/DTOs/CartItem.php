<?php

namespace App\DTOs;

class CartItem
{
    public function __construct(
        public string $name,
        public float $unitPrice,
        public int $quantity
    ) {
    }

    public function getPrice(): float
    {
        // Rounding to avoid float calc issues.
        return round($this->unitPrice * $this->quantity, 2);
    }
}
