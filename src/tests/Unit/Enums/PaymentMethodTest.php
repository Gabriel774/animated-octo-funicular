<?php

namespace Tests\Unit\Enums;

use App\Enums\PaymentMethod;
use App\Services\Cart\PriceModifiers\Contracts\PriceModifier;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    public function test_is_credit_card_method(): void
    {
        $this->assertTrue(PaymentMethod::CREDIT_CARD_FULL->isCreditCard());

        $this->assertTrue(PaymentMethod::CREDIT_CARD_INSTALLMENT->isCreditCard());

        $this->assertFalse(PaymentMethod::PIX->isCreditCard());
    }

    public function test_get_price_modifiers(): void
    {
        $modifiers = collect(PaymentMethod::PIX->getPriceModifiers());

        $this->assertTrue($modifiers->every(fn($modifier): bool => $modifier instanceof PriceModifier));
    }
}
