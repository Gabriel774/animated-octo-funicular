<?php

namespace Tests\Unit\Cart\PriceModifiers;

use App\Services\Cart\PriceModifiers\CompoundInterest\CompoundInterestModifier;
use InvalidArgumentException;
use Tests\TestCase;

class CompoundInterestModifierTest extends TestCase
{
    public function test_10_installments_interest_with_1_percent_interest(): void
    {
        $result = (new CompoundInterestModifier(1))->apply(200, ['installments' => 10]);

        $this->assertEquals(220.90, $result);
    }

    public function test_24_installments_interest_with_5_percent_interest(): void
    {
        $result = (new CompoundInterestModifier(5))->apply(1921.93, ['installments' => 24]);

        $this->assertEquals(6198.22, $result);
    }

    public function test_invalid_installments(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new CompoundInterestModifier(1))->apply(200);
    }
}
