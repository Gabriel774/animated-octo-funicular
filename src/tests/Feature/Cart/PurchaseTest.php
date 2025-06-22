<?php

namespace Tests\Feature\Cart;

use App\Enums\PaymentMethod;
use Illuminate\Testing\TestResponse;
use Tests\Factories\CartItemFactory;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    public function test_pix_method(): void
    {
        $payload = $this->getPayload(PaymentMethod::PIX);

        $subTotal = $this->executeRequest($payload)->json()['subTotal'];

        $this->assertEquals(180, $subTotal);
    }

    public function test_credit_card_full_method(): void
    {
        $payload = $this->getPayload(PaymentMethod::CREDIT_CARD_FULL);

        $subTotal = $this->executeRequest($payload)->json()['subTotal'];

        $this->assertEquals(180, $subTotal);
    }

    public function test_credit_card_installment_method(): void
    {
        $payload = $this->getPayload(PaymentMethod::CREDIT_CARD_INSTALLMENT, 10);

        $subTotal = $this->executeRequest($payload)->json()['subTotal'];

        $this->assertEquals(220.9, $subTotal);
    }

    public function test_invalid_payment_method(): void
    {
        $payload = $this->getPayload(PaymentMethod::PIX);

        $payload['paymentMethod'] = 'fiado';

        $response = $this->executeRequest($payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['paymentMethod']);
    }

    public function test_invalid_cart_item(): void
    {
        $payload = $this->getPayload(PaymentMethod::PIX);

        $payload['items'] = [[]];

        $response = $this->executeRequest($payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'items.0.name',
            'items.0.unitPrice',
            'items.0.quantity',
        ]);
    }


    public function test_no_cart_item_error(): void
    {
        $payload = $this->getPayload(PaymentMethod::PIX);

        $payload['items'] = null;

        $response = $this->executeRequest($payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['items']);
    }

    public function test_invalid_credit_card_data(): void
    {
        $payload = $this->getPayload(PaymentMethod::CREDIT_CARD_FULL);

        $payload['creditCardData'] = [
            'holderName' => 'a',
            'cardNumber' => '2',
            'expirationDate' => '1231-2029',
            'securityCode' => '1'
        ];

        $response = $this->executeRequest($payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'creditCardData.holderName',
            'creditCardData.cardNumber',
            'creditCardData.expirationDate',
            'creditCardData.securityCode',
        ]);
    }

    public function getPayload(PaymentMethod $method, ?int $installments = null): array
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

        if ($installments) {
            $payload['installments'] = $installments;
        }

        return $payload;
    }

    public function executeRequest(array $payload): TestResponse
    {
        return $this->postJson(route('api.cart.purchase'), $payload);
    }
}
