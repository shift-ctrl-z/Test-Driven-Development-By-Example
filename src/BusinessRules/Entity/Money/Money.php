<?php

declare(strict_types=1);

namespace BusinessRules\Entity\Money;

class Money implements Expression
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    private $currency;

    public function __construct(int $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public static function dollar(int $amount): Money
    {
        return new Money($amount, 'USD');
    }

    public static function franc(int $amount): Money
    {
        return new Money($amount, 'CHF');
    }

    public function plus(Expression $addend): Expression
    {
        return new Sum($this, $addend);
    }

    public function times(int $multiplier): Expression
    {
        return new Money($multiplier * $this->amount, $this->currency);
    }

    public function equals(Money $money): bool
    {
        return $this->getCurrency() === $money->getCurrency()
            && $this->amount === $money->amount;
    }

    public function reduce(Bank $bank, string $to): Money
    {
        $rate = $bank->rate($this->currency,$to);
        return new Money($this->amount/$rate,$to);
    }
}