<?php

declare(strict_types=1);

namespace tests\BusinessRules\Entity\Money;

use BusinessRules\Entity\Money\Bank;
use BusinessRules\Entity\Money\Dollar;
use BusinessRules\Entity\Money\Franc;
use BusinessRules\Entity\Money\Money;
use BusinessRules\Entity\Money\Sum;
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

    final public function testSimpleAddition(): void
    {

        $five = Money::dollar(5);
        $sum = $five->plus($five);
        $bank = new Bank();
        $reduced = $bank->reduce($sum, 'USD');
        $this->assertEquals(Money::dollar(10), $reduced);
    }

    final public function testPlusReturnsSum(): void
    {
        $five = Money::dollar(5);
        $result = $five->plus($five);
        $sum = $result;
        $this->assertEquals($five, $sum->augend);
        $this->assertEquals($five, $sum->addend);
    }

    final public function testReduceMoney(): void
    {
        $bank = new Bank();
        $result = $bank->reduce(Money::dollar(1), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    final public function testReduceMoneyDifferentCurrency(): void
    {
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $result = $bank->reduce(Money::franc(2), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    final public function testMixedAddition(): void
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $result = $bank->reduce($fiveBucks->plus($tenFrancs), 'USD');
        $this->assertEquals(Money::dollar(10), $result);
    }

    final public function testSumPlusMoney(): void
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $sum = (new Sum($fiveBucks,$tenFrancs))->plus($fiveBucks);
        $result = $bank->reduce($sum,'USD');
        $this->assertEquals(Money::dollar(15), $result);
    }

    final public function testSumTimesMoney(): void
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $sum = (new Sum($fiveBucks,$tenFrancs))->times(2);
        $result = $bank->reduce($sum,'USD');
        $this->assertEquals(Money::dollar(20), $result);
    }
}
