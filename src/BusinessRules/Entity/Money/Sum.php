<?php


namespace BusinessRules\Entity\Money;


class Sum implements Expression
{
    /**
     * @var Expression
     */
    public $addend;

    /**
     * @var Expression
     */
    public $augend;

    public function __construct(Expression $addend, Expression $augend)
    {
        $this->addend = $addend;
        $this->augend = $augend;
    }

    public function reduce(Bank $bank, string $to): Money
    {
        $amount = $this->augend->reduce($bank, $to)->amount + $this->addend->reduce($bank, $to)->amount;
        return new Money($amount, $to);
    }

    public function plus(Expression $addend): Expression
    {
        return new Sum($this, $addend);
    }

    public function times(int $multiplier): Expression
    {
        return new Sum($this->augend->times($multiplier),$this->addend->times($multiplier));
    }
}