<?php

declare(strict_types=1);

namespace BusinessRules\Entity\Money;

class Money
{
    /**
     * @var int
     */
    protected $amount;

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
        return new Money($amount,'USD');
    }

    public static function franc(int $amount): Money
    {
        return new Money($amount,'CHF');
    }

    public function times(int $multiplier):Money
    {
        return new Money($multiplier * $this->amount,$this->currency);
    }

    public function equals(Money $money): bool
    {
        return $this->getCurrency() === $money->getCurrency()
            && $this->amount === $money->amount;
    }
}