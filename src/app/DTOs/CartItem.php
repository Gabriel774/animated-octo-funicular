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
        return truncateFloat($this->unitPrice * $this->quantity);
    }
}
