<?php

namespace App\Models\Crypto;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CryptoRepository extends Model
{
    private const URL = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';

    public static function getCacheCurrencies(): array
    {
        $cacheKey = 'cryptoCurrencies';
        $cacheExpiration = 600;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $parameters = [
            'start' => 1,
            'limit' => 500,
            'convert' => 'EUR'
        ];

        $headers = [
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('CRYPTO_API_KEY')
        ];

        $response = (new Client)->request('GET', self::URL, [
            'query' => $parameters,
            'headers' => $headers
        ]);

        $cryptoCurrencies = json_decode($response->getBody())->data;

        Cache::put($cacheKey, $cryptoCurrencies, $cacheExpiration);

        return $cryptoCurrencies;
    }

    public static function getRealTimeCurrencyResponse(): array
    {
        $parameters = [
            'start' => 1,
            'limit' => 500,
            'convert' => 'EUR'
        ];

        $headers = [
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('CRYPTO_API_KEY')
        ];

        $response = (new Client)->request('GET', self::URL, [
            'query' => $parameters,
            'headers' => $headers
        ]);

        return json_decode($response->getBody())->data;
    }
}
