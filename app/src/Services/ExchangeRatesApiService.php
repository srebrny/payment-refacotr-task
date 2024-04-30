<?php

namespace Application\Services;

use Application\Contracts\CurrencyRatesProviderInterface;

class ExchangeRatesApiService implements CurrencyRatesProviderInterface
{
    public function __construct(private readonly string $apiKey)
    {
    }

    /**
     * @throws \JsonException
     */
    public function getExchangeRate(string $from, string $to): float
    {
        $responseRaw = $this->apiCall($from, $to);
        $response = json_decode($responseRaw, false, 512, JSON_THROW_ON_ERROR);
        return (float)$response->rates->{$to};
    }

    protected function apiCall(string $from, string $to): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/latest?symbols=$to&base=$from",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: " . $this->apiKey
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
