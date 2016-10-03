<?php

use App\Presenters\Currency;

class CurrencyTest extends TestCase
{
    /** @test */
    public function it_shows_the_right_price()
    {
        $this->assertEquals('$195,24', Currency::from(19524));
    }

    /** @test */
    public function it_allows_using_the_helper_function()
    {
        $this->assertInstanceOf(Currency::class, currency());

        $this->assertEquals('$2,99', currency(299));
    }
}
