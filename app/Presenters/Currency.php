<?php

namespace App\Presenters;


class Currency
{
    /**
     * Returns a string representing the currency for the given price/amount.
     *
     * @param int $amount
     * @return string
     */
    public static function from(int $amount)
    {
        if($amount < 0) {
            return substr(money_format("$%i", $amount / 100), 0, -5) . ")";
        }

        return rtrim(substr(money_format("$%i", $amount / 100), 0, -4));
    }
}