<?php

namespace Application\Services;

use Application\Contracts\CommissionRatesServiceInterface;

class CommissionRatesService implements CommissionRatesServiceInterface
{
    const string EURO = "EUR";
    const array EUROPEAN_COUNTRY = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function isEu(string $country): bool
    {
        return in_array($country, self::EUROPEAN_COUNTRY, true);
    }

    public function calculate(string $currency, float $amount, float $rate, string $country): float
    {
        $amntFixed = 0;
        if ($currency === self::EURO) {
            if ($rate === 0.00) {
                $amntFixed = $amount;
            }
        } else {
            if ($rate > 0) {
                $amntFixed = $amount / $rate;
            }
        }

        return $amntFixed * ($this->isEu($country) ? 0.01 : 0.02);
    }
}
