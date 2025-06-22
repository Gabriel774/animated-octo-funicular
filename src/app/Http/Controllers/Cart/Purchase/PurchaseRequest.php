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
        $requiredIfCreditCard = "required_if:paymentMethod,{$creditCardFullEnumValue},{$creditCardInstallmentEnumValue}";

        return [
            'paymentMethod' => ['required', new Enum(PaymentMethod::class)],
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string'],
            'items.*.unitPrice' => ['required', 'numeric'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'installments' => ["required_if:paymentMethod,{$creditCardInstallmentEnumValue}", 'integer'],
            'creditCardData' => ['array', $requiredIfCreditCard],
            'creditCardData.holderName' => [$requiredIfCreditCard, 'string', 'min:3', 'max:50', 'regex:/^[\pL\s\-\'\.]+$/u'],
            'creditCardData.cardNumber' => [$requiredIfCreditCard, 'string', 'regex:/^(?:\d{13,19})$/'],
            'creditCardData.expirationDate' => [$requiredIfCreditCard, 'string', 'date_format:m-Y'],
            'creditCardData.securityCode' => [$requiredIfCreditCard, 'string', 'regex:/^\d{3,4}$/'],
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
