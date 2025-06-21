<?php

namespace Tests\Factories;

use Faker\Factory as FakerFactory;
use App\DTOs\CartItem;

class CartItemFactory
{
    public static function make(array $overrides = []): CartItem
    {
        $faker = FakerFactory::create();

        return new CartItem(
            name: $overrides['name'] ?? $faker->word,
            unitPrice: $overrides['unitPrice'] ?? $faker->randomFloat(2, 5, 500),
            quantity: $overrides['quantity'] ?? $faker->numberBetween(1, 10)
        );
    }

    public static function many(int $count, array $overrides = []): array
    {
        return collect(range(1, $count))
            ->map(fn() => self::make($overrides))
            ->toArray();
    }
}