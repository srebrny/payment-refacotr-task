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

        if ($currency === self::EURO || $rate === 0.00) {
            $amntFixed = $amount;
        }
        if ($currency !== self::EURO || $rate > 0.00) {
            $amntFixed = $amount / $rate;
        }

        $provision = $amntFixed * ($this->isEu($country) ? 0.01 : 0.02);

        return round($provision, 2);
    }
}
