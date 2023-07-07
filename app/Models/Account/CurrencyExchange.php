<?php

namespace App\Models\Account;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;

class CurrencyExchange extends Model
{
    private const URL = "https://www.latvijasbanka.lv/vk/ecb.xml";


    /**
     * @throws GuzzleException
     */
    public static function getCurrency(): array
    {
        $client = new Client();
        $response = $client->get(self::URL);
        $currencyData = simplexml_load_string($response->getBody()->getContents());
        $IDs = [];

        foreach ($currencyData->Currencies->Currency as $currency) {
            $id = (string) $currency->ID;
            $IDs[] = $id;
        }

        return $IDs;
    }

    /**
     * @throws GuzzleException
     */
    public static function getCurrencyRate(string $input): float
    {
        $client = new Client();
        $response = $client->get(self::URL);
        $currencyData = simplexml_load_string($response->getBody()->getContents());
        $rate = "";
        if ($input == 'EUR') {
            return 1;
        }
        foreach ($currencyData->Currencies->Currency as $currency) {
            $id = (string) $currency->ID;
            $rate = (float) $currency->Rate;

            if ($id == $input) {
                return $rate;
            }
        }

        return $rate;
    }
}
