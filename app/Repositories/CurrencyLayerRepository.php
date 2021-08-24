<?php

namespace App\Repositories;

use http\Exception;

class CurrencyLayerRepository
{

    protected $url = 'http://api.currencylayer.com/live?access_key=';

    public function __construct()
    {
        $this->url.= config('currency-layer.access_key');
    }

    /**
     * @return bool|string
     */
    public function call()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 0);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }

            if (isset($error_msg)) {
                dd($error_msg);
            }
            $server_output = curl_exec($ch);

            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            return json_decode($server_output, true);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function get()
    {
        return $this->call();
    }
}
