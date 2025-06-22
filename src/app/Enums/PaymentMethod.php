<?php

namespace App\Enums;

use App\Services\Cart\PriceModifiers\CompoundInterest\CompoundInterestModifier;
use App\Services\Cart\PriceModifiers\Discount\DiscountModifier;
use App\Services\Cart\PriceModifiers\Discount\DiscountType;

enum PaymentMethod: string
{
    case PIX = 'pix';

    case CREDIT_CARD_FULL = 'credit_card_full';

    case CREDIT_CARD_INSTALLMENT = 'credit_card_installment';

    public function isCreditCard(): bool
    {
        return in_array($this, [static::CREDIT_CARD_FULL, static::CREDIT_CARD_INSTALLMENT]);
    }

    public function getPriceModifiers(): array
    {
        return match ($this) {
            static::PIX, static::CREDIT_CARD_FULL => [new DiscountModifier(10, DiscountType::PERCENTAGE)],
            static::CREDIT_CARD_INSTALLMENT => [new CompoundInterestModifier(1)]
        };
    }
}
