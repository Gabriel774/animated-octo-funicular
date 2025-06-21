<?php

namespace Tests\Unit\Cart;

use App\Services\CartCalculator;
use Tests\Factories\CartItemFactory;
use Tests\TestCase;

class CartCalculatorTest extends TestCase
{
    public function test_get_sub_total(): void
    {
        $items = [
            CartItemFactory::make(['unitPrice' => 75.15, 'quantity' => 2]),
            CartItemFactory::make(['unitPrice' => 21.02, 'quantity' => 1])
        ];

        $subTotal = (new CartCalculator($items))->getSubTotal();

        $this->assertEquals(171.32, $subTotal);
    }
}