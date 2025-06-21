<?php

namespace App\Services\Cart\PriceModifiers\Discount;

enum DiscountType: string
{
    case PERCENTAGE = 'percentage';

    case FIXED = 'fixed';
}
