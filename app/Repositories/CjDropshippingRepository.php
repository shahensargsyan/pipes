<?php

namespace App\Repositories;

use http\Exception;

class CjDropshippingRepository
{

    protected $url = 'https://developers.cjdropshipping.com';
    protected $action;
    protected $payload;

    private $cjAccessToken;


    public function __construct()
    {
        $this->cjAccessToken = config('cj.access_token');
    }

    /**
     * @param $payload
     * @return bool|string
     */
    public function call()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url.$this->action);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->payload, JSON_UNESCAPED_SLASHES));
            curl_setopt($ch, CURLOPT_HEADER , true);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'CJ-Access-Token: '.$this->cjAccessToken,
                'Content-Type: application/json',
                'accept: application/json',
            ));

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }

            if (isset($error_msg)) {
                dd($error_msg);
            }
            $server_output = curl_exec($ch);

            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            return $server_output;
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function addProduct($payload)
    {
        $this->action = '/api/product/createProducts';
        $this->payload = $payload;
        return $this->call();
    }

    /**
     * @param $payload
     * @return bool|string
     */
    public function createOrders($payload)
    {
        $this->action = '/api/order/createOrders';
        $this->payload = $payload;
        return $this->call();
    }

    public function getProductConnectList($payload = ["type" => 0])
    {
        $this->action = '/api/product/connectList';
        $this->payload = $payload;
        return  $this->call();
    }

    public function deleteShopProducts($payload)
    {
        $this->action = '/api/product/deleteProducts';
        $this->payload = $payload;
        return $this->call();
    }

}
