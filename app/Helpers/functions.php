<?php

use App\Presenters\Currency;

if(!function_exists('currency')) {
    function currency(int $amount = null) {
        if($amount === null) {
            return new Currency;
        }

        return Currency::from($amount);
    }
}