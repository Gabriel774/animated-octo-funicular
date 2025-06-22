<?php

namespace Tests\Feature\Cart;

use App\Enums\PaymentMethod;
use Tests\Factories\CartItemFactory;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    public function test_pix_method(): void
    {
        $payload = $this->getPayload(PaymentMethod::PIX);

        $subTotal = $this->executeRequest($payload)['subTotal'];

        $this->assertEquals(180, $subTotal);
    }

    public function getPayload(PaymentMethod $method): array
    {
        $payload = [
            'items' => [
                CartItemFactory::make(['unitPrice' => 37.5, 'quantity' => 2]),
                CartItemFactory::make(['unitPrice' => 10, 'quantity' => 1]),
                CartItemFactory::make(['unitPrice' => 15, 'quantity' => 1]),
                CartItemFactory::make(['unitPrice' => 71.2, 'quantity' => 1]),
                CartItemFactory::make(['unitPrice' => 28.8, 'quantity' => 1]),
            ],
            'paymentMethod' => $method->value
        ];

        if ($method->isCreditCard()) {
            $payload['creditCardData'] = [
                'holderName' => 'lorem ipsum',
                'cardNumber' => '5223419729253510',
                'expirationDate' => '07-2029',
                'securityCode' => '123'
            ];
        }

        return $payload;
    }

    public function executeRequest(array $payload): array
    {
        return $this->postJson(route('api.cart.purchase'), $payload)->json();
    }
}
