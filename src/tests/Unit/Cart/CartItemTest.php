<?php

namespace Tests\Unit\Cart;

use Tests\Factories\CartItemFactory;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    public function test_get_price(): void
    {
        $price = CartItemFactory::make([
            'unitPrice' => 105.31,
            'quantity' => 3
        ])->getPrice();

        $this->assertEquals(315.93, $price);
    }
}