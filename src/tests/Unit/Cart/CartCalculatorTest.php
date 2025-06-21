<?php

namespace Tests\Unit\Cart;

use App\Services\Cart\CartCalculator;
use Tests\Factories\CartItemFactory;
use Tests\TestCase;

class CartCalculatorTest extends TestCase
{
    public function test_get_sub_total(): void
    {
        $items = $this->getDummyItems();

        $subTotal = (new CartCalculator($items))->getSubTotal();

        $this->assertEquals(171.32, $subTotal);
    }

    public function test_get_sub_total_with_modifiers(): void
    {
        $items = $this->getDummyItems();

        
    }

    protected function getDummyItems(): array
    {
        return [
            CartItemFactory::make(['unitPrice' => 75.15, 'quantity' => 2]),
            CartItemFactory::make(['unitPrice' => 21.02, 'quantity' => 1])
        ];
    }
}