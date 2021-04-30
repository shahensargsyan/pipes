<?php

namespace Botble\Payment\Services\Gateways;

use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Services\Abstracts\StripePaymentAbstract;
use Botble\Payment\Services\Traits\PaymentTrait;
use Botble\Payment\Supports\StripeHelper;
use Exception;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripePaymentService extends StripePaymentAbstract
{
    use PaymentTrait;

    /**
     * Make a payment
     *
     * @param Request $request
     *
     * @return array
     * @throws ApiErrorException
     */
    public function makePayment(Request $request): array
    {
        $this->amount = $request->input('amount');
        $this->currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $this->currency = strtoupper($this->currency);
        $description = $request->input('description');

        Stripe::setApiKey(setting('payment_stripe_secret'));
        Stripe::setClientId(setting('payment_stripe_client_id'));

        $amount = $this->amount;

        $multiplier = StripeHelper::getStripeCurrencyMultiplier($this->currency);

        if ($multiplier > 1) {
            $amount = (int) ($amount * $multiplier);
        }

        // Create Customer In Stripe
        $customer = Customer::create(array(
            "email" => $request->address['email'],
            "source" => $request->stripeToken
        ));

        // Charge Customer
        $charge = Charge::create(array(
            'amount' => $amount,
            'currency'    => $this->currency,
            'description' => $description,
            'customer' => $customer->id
        ));

        $this->chargeId = $charge['id'];

        return [
            'chargeId' => $this->chargeId,
            'customerId' => $customer->id,
        ];
    }

    /**
     * Use this function to perform more logic after user has made a payment
     *
     * @param array $chargeData
     * @param Request $request
     *
     * @return mixed
     */
    public function afterMakePayment(array $chargeData, Request $request)
    {

        try {
            $payment = $this->getPaymentDetails($chargeData['chargeId']);

            if ($payment && ($payment->paid || $payment->status == 'succeeded')) {
                $paymentStatus = PaymentStatusEnum::COMPLETED;
            } else {
                $paymentStatus = PaymentStatusEnum::FAILED;
            }
        } catch (Exception $exception) {
            $paymentStatus = PaymentStatusEnum::FAILED;
        }

        $this->storeLocalPayment([
            'amount'             => $this->amount,
            'currency'           => $this->currency,
            'charge_id'          => $chargeData['chargeId'],
            'order_id'           => $request->input('order_id'),
            'payment_channel'    => PaymentMethodEnum::STRIPE,
            'status'             => $paymentStatus,
            'stripe_customer_id' => $chargeData['customerId'],
        ]);

        return true;
    }

    /**
     * Update a payment
     * @param Request $request
     * @param string $customerId
     * @param float $amount
     * @param string $description
     * @throws ApiErrorException
     * @return string
     */
    public function updatePayment(Request $request, string $customerId, float $amount, string $description): string
    {
        Stripe::setApiKey(setting('payment_stripe_secret'));
        Stripe::setClientId(setting('payment_stripe_client_id'));

        $this->currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $this->currency = strtoupper($this->currency);

        $multiplier = StripeHelper::getStripeCurrencyMultiplier($this->currency);

        if ($multiplier > 1) {
            $amount = (int) ($amount * $multiplier);
        }

        // Charge Customer
        $charge = Charge::create(array(
            'amount' => $amount,
            'currency'    => $this->currency,
            'description' => $description,
            'customer' => $customerId
        ));

        $this->chargeId = $charge['id'];

        return $this->chargeId;
    }
}
