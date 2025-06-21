<?php

namespace App\Services\Cart;

use App\DTOs\CartItem;

class CartCalculator
{

    public function __construct(
        public array $items,
        public array $priceModifiers = []
    ) {
    }

    public function getSubTotal(): float
    {
        $itemsSum = $this->sumItemsPrice();

        return $this->applyPriceModifiers($itemsSum);
    }

    private function sumItemsPrice(): float
    {
        return collect($this->items)
            ->reduce(
                fn(float $carry, CartItem $item): float => round($item->getPrice() + $carry, 2),
                0
            );
    }

    protected function applyPriceModifiers(float $value): float
    {
        //@todo: implement
        return $value;
    }
}
