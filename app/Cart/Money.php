<?php
namespace App\Cart;

use Money\Currency;
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;


class Money
{
    protected $money;

    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('EGP'));
    }

    public function formatted()
    {
        $moneyFormatter = new IntlMoneyFormatter(
            new NumberFormatter('en_EGP', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $moneyFormatter->format($this->money);
    }

    public function amount()
    {
        return $this->money->getAmount();    
    }
}
