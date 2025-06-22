<?php

namespace App\Services\Cart;

use App\DTOs\CartItem;
use App\Services\Cart\PriceModifiers\Contracts\PriceModifier;

class CartCalculator
{
    /**
     * @param CartItem[] $items
     * @param PriceModifier[] $priceModifiers
     * @param array $context
     */
    public function __construct(
        public array $items,
        public array $priceModifiers = [],
        public array $context = []
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
                fn(float $carry, CartItem $item): float => truncateFloat($item->getPrice() + $carry),
                0
            );
    }

    protected function applyPriceModifiers(float $value): float
    {
        return collect($this->priceModifiers)->reduce(
            fn(float $carry, PriceModifier $modifier) => $modifier->apply($carry, $this->context),
            $value
        );
    }
}
