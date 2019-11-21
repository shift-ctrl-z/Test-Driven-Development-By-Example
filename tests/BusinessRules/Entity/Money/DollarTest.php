<?php

declare(strict_types=1);

namespace tests\BusinessRules\Entity\Money;

use BusinessRules\Entity\Money\Dollar;
use PHPUnit\Framework\TestCase;

class DollarTest extends TestCase
{
    final public function testMultiplication(): void
    {
        $fiveDollars = new Dollar(5);
        $fiveDollars->times(2);
        $this->assertEquals(10, $fiveDollars->amount);
    }
}
