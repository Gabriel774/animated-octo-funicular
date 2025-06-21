<?php

namespace Tests\Unit\Cart;

use App\DTOs\CartItem;
use Tests\Factories\CartItemFactory;
use Tests\TestCase;

class CartItemFactoryTest extends TestCase
{
    public function test_factory_single_item(): void
    {
        $cartItem = CartItemFactory::make();

        $this->assertIsInt($cartItem->quantity);

        $this->assertIsString($cartItem->name);

        $this->assertIsFloat($cartItem->unitPrice);
    }

    public function test_factory_override(): void
    {
        $name = "Example item";
        $quantity = 5;
        $unitPrice = 99.99;

        $cartItem = CartItemFactory::make(compact('name', 'quantity', 'unitPrice'));

        $this->assertEquals($name, $cartItem->name);

        $this->assertEquals($quantity, $cartItem->quantity);

        $this->assertEquals($unitPrice, $cartItem->unitPrice);
    }

    public function test_factory_mass_creation(): void
    {
        $items = collect(CartItemFactory::many(10));

        $this->assertTrue($items->every(fn($item): bool => $item instanceof CartItem));

        $this->assertEquals(10, $items->count());
    }
}