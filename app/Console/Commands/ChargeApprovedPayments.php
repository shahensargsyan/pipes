<?php

namespace App\Console\Commands;

use Botble\Ecommerce\Repositories\Interfaces\OrderInterface;
use Botble\Payment\Services\Gateways\PayPalPaymentService;
use Illuminate\Console\Command;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Carbon\Carbon;
use OrderHelper;

class ChargeApprovedPayments extends Command
{
    /**
     * @var PayPalPaymentService
     */
    protected $payPalService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:charge-approved-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge Approved PayPal Payments';

    /**
     * Create a new command instance.
     * @param PayPalPaymentService $payPalService
     *
     * @return void
     */
    public function __construct(
        PayPalPaymentService $payPalService
    )
    {
        parent::__construct();
        $this->payPalService = $payPalService;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payments = app(PaymentInterface::class)->advancedGet([
            'condition' => [
                ['created_at', '<', Carbon::now()->subMinutes(15),],
                'status' => 'APPROVED',
                'payment_channel' => 'paypal'
            ]
        ]);

        foreach ($payments as $payment) {
            //dd($payment->charge_id);
            $this->payPalService->captureAuthorize($payment->charge_id);
            $order = app(OrderInterface::class)->getFirstBy(['id' => $payment->order_id]);
            OrderHelper::finishOrder($token, $order);
        }

        dd($payments);
    }
}
