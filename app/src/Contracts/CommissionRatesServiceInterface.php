<?php

namespace Application\Contracts;

interface CommissionRatesServiceInterface
{
    public function calculate(string $currency, float $amount, float $rate, string $country);

}
