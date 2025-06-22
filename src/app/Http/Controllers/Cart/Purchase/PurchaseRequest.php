<?php

namespace App\Http\Controllers\Cart\Purchase;

use App\DTOs\CartItem;
use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        $creditCardFullEnumValue = PaymentMethod::CREDIT_CARD_FULL->value;
        $creditCardInstallmentEnumValue = PaymentMethod::CREDIT_CARD_INSTALLMENT->value;
        $requiredIfCreditCard = "required_if:payment_method,{$creditCardFullEnumValue},{$creditCardInstallmentEnumValue}";

        return [
            'paymentMethod' => ['required', new Enum(PaymentMethod::class)],
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string'],
            'items.*.unitPrice' => ['required', 'numeric'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'installments' => [$requiredIfCreditCard, 'integer'],
            'creditCardData' => ['array', $requiredIfCreditCard],
            'creditCardData.holderName' => [$requiredIfCreditCard, 'string'],
            'creditCardData.cardNumber' => [$requiredIfCreditCard, 'string'],
            'creditCardData.expirationDate' => [$requiredIfCreditCard, 'string'],
            'creditCardData.securityCode' => [$requiredIfCreditCard, 'string'],
        ];
    }

    public function getCartItems(): array
    {
        return collect($this->validated('items'))
            ->map(fn($item) => new CartItem(
                $item['name'],
                (float) $item['unitPrice'],
                (int) $item['quantity']
            ))
            ->all();
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return PaymentMethod::from($this->validated('paymentMethod'));
    }
}
