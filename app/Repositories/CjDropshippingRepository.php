<?php

namespace App\Repositories;

use http\Exception;
use Session;

class CjDropshippingRepository
{

    protected $url = 'https://developers.cjdropshipping.com';

    private $cjAccessToken;


    public function __construct()
    {
        $this->cjAccessToken = config('cj.access_token');
    }

    /**
     * @param $payload
     * @return bool|string
     */
    public function addProduct($payload)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $action = 'https://developers.cjdropshipping.com/api/product/createProducts';

//dd(json_encode($payload, JSON_UNESCAPED_SLASHES));
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $action);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
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

            return $statusCode;
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * @param $action
     * @param $payload
     * @param $headers
     * @param string $method
     * @return mixed
     */
    public function call($action, $payload, $headers, $method = 'POST')
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url . $action);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            switch ($method) {
                case 'PUT':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
                    break;
                case 'GET':
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    break;
                default:
                    curl_setopt($ch, CURLOPT_POST, 1);
//                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'accept: application/json',
                        'Content-Type: multipart/form-data;',
                        'accept-encoding: gzip, deflate, br'
                    ));

            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }

            if (isset($error_msg)) {
                dd($error_msg);
            }
            $server_output = json_decode(curl_exec($ch));

            curl_close($ch);

            return $server_output;

        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * @return mixed
     */
    public function getBackendToken()
    {
        $action = "/auth/backend_token/onboarding";

        $headers = [
            'authorization: Bearer '.$this->loginToken,
        ];
        $payload = [];

        $backendToken = $this->backendtoken;

        if (!isset($backendToken)){
            $request = $this->call($action, $payload, $headers, $method='GET');

            $this->backendtoken = $request->token;

            return  $request->token;
        }

        return $this->backendtoken = $backendToken;
    }

    /**
     * @param string $userId
     * @return array
     */
    public function getServiceBackendToken($userId)
    {
        $action = "/auth/backend_token/onboarding/".$userId;

        $headers = [
            'authorization: Bearer ' . $this->loginToken,
        ];

        $serviceBackendToken = $this->serviceBackendToken;

        if (!isset($serviceBackendToken)){
            $request = $this->call($action, $payload = [], $headers, $method='GET');

            $this->serviceBackendToken = $request->token;
            return  $request->token;
        }

        return $this->backendtoken = $serviceBackendToken;
    }

    /**
     * @param string $email
     * @return array
     */
    public function getUserToken($user_id)
    {
        $action = "/auth/user_token/onboarding/".$user_id;

        $headers = [
            'authorization: Bearer ' . $this->loginToken,
        ];

        $payload = [];
        $token = Session::get('alicebiometrics-user-token');

        if (!isset($token)){
            $response = $this->call($action, $payload, $headers, $method='GET');
            //Session::put('alicebiometrics-user-token', $response->token);

            $this->userToken = $response->token;
            $token = $this->userToken;
        }

        return $token;
    }


    /**
     * @param $email
     * @return mixed
     */
    public function createOnboardingUser($email)
    {
        $action = '/onboarding/user';

        $headers = [
            'authorization: Bearer '.$this->backendtoken,
            'content-type: multipart/form-data'
        ];

        $payload = [
            'email' =>  $email,
        ];

        return  $this->call($action, $payload, $headers);
    }

    /**
     * @return mixed
     */
    public function checkUserStatus()
    {
        $action = '/onboarding/user/status';

        $headers = [
            'authorization: Bearer '.$this->userToken,
            'content-type: multipart/form-data'
        ];

        $payload = [];

        return  $this->call($action, $payload, $headers, $method='GET');
    }

    /**
     * @return mixed
     */
    public function onboardingUserAuthorize()
    {
        $action = '/onboarding/user/authorize';

        $headers = [
            'authorization: Bearer '.$this->serviceBackendToken,
            'content-type: multipart/form-data'
        ];

        $payload = [];

        return  $this->call($action, $payload, $headers, $method='POST');
    }

    /**
     * @return mixed
     */
    public function getUserReport()
    {
        $action = '/onboarding/user/report';

        $headers = [
            'authorization: Bearer '.$this->serviceBackendToken,
            'content-type: multipart/form-data'
        ];

        $payload = [];

        return  $this->call($action, $payload, $headers, $method='GET');
    }
}
