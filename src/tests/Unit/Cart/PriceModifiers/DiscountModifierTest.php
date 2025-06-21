<?php

namespace Tests\Unit\Cart\PriceModifiers;

use App\Services\Cart\PriceModifiers\Discount\DiscountModifier;
use App\Services\Cart\PriceModifiers\Discount\DiscountType;
use Tests\TestCase;

class DiscountModifierTest extends TestCase
{
    public function test_discount_percentage_modifier(): void
    {
        $result = (new DiscountModifier(30, DiscountType::PERCENTAGE))->apply(1000);

        $this->assertEquals(700, $result);
    }

    public function test_discount_fixed_modifier(): void
    {
        $result = (new DiscountModifier(30, DiscountType::FIXED))->apply(1000);

        $this->assertEquals(970, $result);
    }

    public function test_discount_fixed_modifier_greater_than_price(): void
    {
        $result = (new DiscountModifier(30, DiscountType::FIXED))->apply(3);

        $this->assertEquals(0, $result);
    }
}
