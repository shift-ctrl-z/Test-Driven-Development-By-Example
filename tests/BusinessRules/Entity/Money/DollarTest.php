<?php

declare(strict_types=1);

namespace tests\BusinessRules\Entity\Money;

use BusinessRules\Entity\Money\Dollar;
use BusinessRules\Entity\Money\Franc;
use BusinessRules\Entity\Money\Money;
use PHPUnit\Framework\TestCase;

class DollarTest extends TestCase
{
    final public function testDollarMultiplications(): void
    {
        $this->assertTrue(Money::dollar(10)->equals(Money::dollar(5)->times(2)));
        $this->assertTrue(Money::dollar(15)->equals(Money::dollar(5)->times(3)));
    }

    final public function testEquality(): void
    {
        $this->assertTrue((Money::dollar(5))->equals(Money::dollar(5)));
        $this->assertFalse((Money::dollar(5))->equals(Money::dollar(6)));
        $this->assertFalse((Money::franc(5))->equals(Money::dollar(5)));
    }

    final public function testCurrency(): void
    {
        $this->assertEquals('USD', Money::dollar(1)->getCurrency());
        $this->assertEquals('CHF', Money::franc(1)->getCurrency());
    }
}
