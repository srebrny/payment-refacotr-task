<?php

namespace Unit\Services;

use Application\Services\ExchangeRatesApiService;
use Codeception\Test\Unit;

class ExchangeRatesApiServiceTest extends Unit
{

    public function testExchangeServiceMockupApiCall(): void
    {
        $exchangeRatesApiServiceMock = $this->construct(ExchangeRatesApiService::class, ["Example of key"], [
            'apiCall'=>'{"base": "EUR","date": "2024-04-30","rates": {"USD": 1.072311},"success": true,"timestamp": 1714468864}'
        ]);

        $rate = $exchangeRatesApiServiceMock->getExchangeRate("EUR", "USD");
        $this->assertEquals("1.072311", $rate);
    }

}
