<?php

namespace Botble\Payment\Services\Gateways;

use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Services\Abstracts\PayPalPaymentAbstract;
use Botble\Payment\Services\Traits\PaymentTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersPatchRequest;
use Sample\PatchOrder;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersAuthorizeRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class PayPalPaymentService extends PayPalPaymentAbstract
{
    use PaymentTrait;

    /**
     * Make a payment
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function makePayment(Request $request)
    {
        $amount = $request->input('amount');

        $data = [
            'name'     => $request->input('name'),
            'quantity' => 1,
            'price'    => $amount,
            'sku'      => null,
            'type'     => PaymentMethodEnum::PAYPAL,
        ];

        $currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $currency = strtoupper($currency);

        $queryParams = [
            'type'     => PaymentMethodEnum::PAYPAL,
            'amount'   => $amount,
            'currency' => $currency,
            'order_id' => $request->input('order_id'),
        ];

        $checkoutUrl = $this
            ->setReturnUrl($request->input('callback_url') . '?' . http_build_query($queryParams))
            ->setCurrency($currency)
            ->setItem($data)
            ->createPayment($request->input('description'));

        return $checkoutUrl;
    }

    /**
     * Use this function to perform more logic after user has made a payment
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function afterMakePayment(Request $request)
    {
        $order = new OrdersGetRequest($request->input('token'));
        $client = $this->client();
        $response = $client->execute($order);

        /*if (!$response->result->status || ($response->result->status && $response->result->status !== PaymentStatusEnum::APPROVED)) {
            $status = PaymentStatusEnum::FAILED;
        }*/

        $this->storeLocalPayment([
            'amount'          => $request->input('amount'),
            'currency'        => $request->input('currency'),
            'charge_id'       => $response->result->id,
            'order_id'        => $request->input('order_id'),
            'payment_channel' => PaymentMethodEnum::PAYPAL,
            'status'          => $response->result->status,
        ]);

        return $response->result->status;
    }

    private static function buildRequestBody($request)
    {
        $amount = $request->input('amount');

        $data = [
            'name'     => $request->input('name'),
            'quantity' => 1,
            'price'    => $amount,
            'sku'      => null,
            'type'     => PaymentMethodEnum::PAYPAL,
        ];

        $currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $currency = strtoupper($currency);

        $queryParams = [
            'type'     => PaymentMethodEnum::PAYPAL,
            'amount'   => $amount,
            'currency' => $currency,
            'order_id' => $request->input('order_id'),
        ];

//        $checkoutUrl = $this
//            ->setReturnUrl($request->input('callback_url') . '?' . http_build_query($queryParams))
//            ->setCurrency($currency)
//            ->setItem($data)
//            ->createPayment($request->input('description'));

        //return $checkoutUrl;

        return array(
            'intent' => 'AUTHORIZE',
            'application_context' =>
                array(
                    'return_url' => $request->input('callback_url') . '?' . http_build_query($queryParams),
                    'cancel_url' => route('public.checkout.information', $request['checkout-token']),
                    'brand_name' => 'EXAMPLE INC',
                    'locale' => 'en-US',
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                    'user_action' => 'PAY_NOW',
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'reference_id' => 'PUHF',
                            'description' => $request->input('description'),
                            'custom_id' => 'CUST-HighFashions',
                            'soft_descriptor' => 'HighFashions',
                            'amount' =>
                                array(
                                    'currency_code' => $currency,
                                    'value' => (float)$amount,
                                    'breakdown' =>
                                        array(
                                            'item_total' =>
                                                array(
                                                    'currency_code' => $currency,
                                                    'value' => (float)$amount,
                                                ),
                                            'shipping' =>
                                                array(
                                                    'currency_code' => $currency,
                                                    'value' => '0.00',
                                                ),
                                            'handling' =>
                                                array(
                                                    'currency_code' => $currency,
                                                    'value' => '0.00',
                                                ),
                                            'tax_total' =>
                                                array(
                                                    'currency_code' => $currency,
                                                    'value' => '0.00',
                                                ),
                                            'shipping_discount' =>
                                                array(
                                                    'currency_code' => $currency,
                                                    'value' => '0.00',
                                                ),
                                        ),
                                ),
                            'items' => [],
                            'shipping' =>
                                array(
                                    'method' => 'United States Postal Service',
                                    'name' =>
                                        array(
                                            'full_name' => 'John Doe',
                                        ),
                                    'address' =>
                                        array(
                                            'address_line_1' => '123 Townsend St',
                                            'address_line_2' => 'Floor 6',
                                            'admin_area_2' => 'San Francisco',
                                            'admin_area_1' => 'CA',
                                            'postal_code' => '94107',
                                            'country_code' => 'US',
                                        ),
                                ),
                        ),
                ),
        );
    }




    public  function createOrder(Request $request)
    {
        $orderRequest = new OrdersCreateRequest();
        $orderRequest->headers["Prefer"] = "return=representation";
        $orderRequest->body =  $this->buildRequestBody($request);

        $client = $this->client();
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($orderRequest);

        }catch (HttpException $ex) {
            //echo $ex->statusCode;
        }

        $config = config('plugins.payment.payment.paypal');
        if ($config["settings"]["mode"] ==  "sandbox") {
            return "https://www.sandbox.paypal.com/checkoutnow?token={$response->result->id}";
        } else {
            return "https://www.paypal.com/checkoutnow?token={$response->result->id}";
        }
    }

    public function patchOrder($orderId, $amount)
    {
        $client = $this->client();

        $request = new OrdersPatchRequest($orderId);
        $request->body = $this->buildPatchRequestBody($amount);
//        dd($request);
        $response = $client->execute($request);
        dd($response);
    }

    /**
     * This function can be used to capture an order payment by passing the approved
     * order id as argument.
     *
     * @param orderId
     * @param debug
     * @returns
     */
    public static function captureOrder($orderId , $debug=false)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');
        try {
            $client = new PayPalHttpClient(new SandboxEnvironment( "AbRnBkC6-vEQON9SWxL1T4iiHmfSY-UV0W_6XbeR7uVkinx-PNOzGK6khX6TqmB6MXcAjBdVbcu1p2IA", "EKMehB_uEEUqFy8PY0_PIDa7URn9VAwMF59JSAHrMR6iTa0lWyBzf7mRLq8sIRZiCSWdeRCB53W4e6Ro"));

            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            print_r($response);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function captureAuthorize($orderId, $debug=false)
    {
        $request = new OrdersAuthorizeRequest($orderId);
        try {
            $client = $this->client();
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            print_r($response);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function getOrder($orderId)
    {

        $client = $this->client();
        $response = $client->execute(new OrdersGetRequest($orderId));

        return $response->result->status;
    }

    private function buildPatchRequestBody($amount)
    {
        return array (
            0 =>
                array (
                    'op' => 'replace',
                    'path' => '/intent',
                    'value' => 'AUTHORIZE',
                ),
            1 =>
                array (
                    'op' => 'replace',
                    'path' => '/purchase_units/@reference_id==\'PUHF\'/amount',
                    'value' =>
                        array (
                            'currency_code' => 'USD',
                            'value' => $amount,
                            'breakdown' =>
                                array (
                                    'item_total' =>
                                        array (
                                            'currency_code' => 'USD',
                                            'value' => $amount,
                                        ),
                                    'tax_total' =>
                                        array (
                                            'currency_code' => 'USD',
                                            'value' => '0.00',
                                        ),
                                ),
                        ),
                ),
        );
    }

    /**
     * Returns PayPal HTTP client instance with environment which has access
     * credentials context. This can be used invoke PayPal API's provided the
     * credentials have the access to do so.
     */
    public function client()
    {
        return new PayPalHttpClient($this->environment());
    }

    /**
     * Setting up and Returns PayPal SDK environment with PayPal Access credentials.
     * For demo purpose, we are using SandboxEnvironment. In production this will be
     * ProductionEnvironment.
     */
    public function environment()
    {
        $config = config('plugins.payment.payment.paypal');
        if ($config["settings"]["mode"] ==  "sandbox") {
            return new SandboxEnvironment($config['client_id'], $config['secret']);
        } else {
            return new ProductionEnvironment($config['client_id'], $config['secret']);
        }
    }
}
