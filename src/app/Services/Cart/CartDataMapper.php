<?php

namespace App\Services\Cart;

use App\Enums\PaymentMethod;

class CartDataMapper
{
    public function __construct(
        protected readonly PaymentMethod $paymentMethod,
        protected readonly ?int $installments = null
    ) {
    }

    public function getModifiers(): array
    {
        $modifiers = [];

        $modifiers = array_merge($modifiers, $this->paymentMethod->getPriceModifiers());

        // other applyable modifiers from cupons, customer credit card brand etc.

        return $modifiers;
    }

    public function getContext(): array
    {
        $context = [];

        if ($this->installments) {
            $context['installments'] = $this->installments;
        }

        // other contexts comming from customer, payment method, product etc.

        return $context;
    }
}
