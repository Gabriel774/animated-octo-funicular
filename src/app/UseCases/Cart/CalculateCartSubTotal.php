<?php

namespace App\UseCases\Cart;

use App\Enums\PaymentMethod;
use App\Services\Cart\CartCalculator;
use App\Services\Cart\CartDataMapper;

class CalculateCartSubTotal
{

    public static function handle(array $cartItems, PaymentMethod $paymentMethod, ?int $installments = null): float
    {
        $cartData = new CartDataMapper($paymentMethod, $installments);

        return (new CartCalculator(
            $cartItems,
            $cartData->getModifiers(),
            $cartData->getContext()
        ))->getSubTotal();
    }
}