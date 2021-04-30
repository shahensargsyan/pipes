<?php

namespace Botble\Payment\Services\Gateways;

use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
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

    /**
     * @param Request $request
     * @return array
     */
    private function buildRequestBody(Request $request): array
    {
        $amount = $request->input('amount');
        $currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $currency = strtoupper($currency);

        $queryParams = [
            'type'     => PaymentMethodEnum::PAYPAL,
            'amount'   => $amount,
            'currency' => $currency,
            'order_id' => $request->input('order_id'),
        ];

        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => $request->input('callback_url') . '?' . http_build_query($queryParams),
                    'cancel_url' => url('/'),
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

        $response = $client->execute($request);

        if ($response->statusCode == 204) {
            return true;
        }

        return false;
    }



    public  function captureOrder($orderId, $debug=true)
    {
        try {
            $request = new OrdersCaptureRequest($orderId);
            $client = $this->client();
            return  $client->execute($request);

        } catch (HttpException $ex) {

        }
    }


    /**
     * @param string $orderId
     * @return mixed
     */
    public function getOrder(string $orderId)
    {
        try {
            $client = $this->client();
            // Call API with your client and get a response for your call
            $response = $client->execute(new OrdersGetRequest($orderId));
            return $response->result->status;

        } catch (HttpException $ex) {

        }

        return false;
    }

    private function buildPatchRequestBody($amount)
    {
        return array (
            0 =>
                array (
                    'op' => 'replace',
                    'path' => '/intent',
                    'value' => 'CAPTURE',
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
