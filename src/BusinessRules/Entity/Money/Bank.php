<?php


namespace BusinessRules\Entity\Money;


class Bank
{
    /**
     * @var int[]
     */
    private $rates;

    public function reduce(Expression $source, string $to): Money
    {
        return $source->reduce($this, $to);
    }

    public function addRate(string $from, string $to, int $rate)
    {
        $this->rates[$from][$to] = $rate;
    }

    public function rate(string $currency, string $to): int
    {
        if ($currency === $to) {
            return 1;
        }
        return $this->rates[$currency][$to];
    }
}