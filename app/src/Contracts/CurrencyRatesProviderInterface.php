<?php

namespace Application\Contracts;

interface CurrencyRatesProviderInterface
{
    public function getExchangeRate(string $from, string $to): float;
}
