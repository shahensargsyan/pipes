<?php

namespace App\Listener;

use App\Event\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\CjDropshippingRepository;

class SendToCjdropshipping
{
    public $cjDropShippingRepository;

    public $countries = [
        "US" => "United States",
        "GB" => "United Kingdom",
        "IE" => "Ireland",
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CjDropshippingRepository $cjDropShippingRepository)
    {
        $this->cjDropShippingRepository = $cjDropShippingRepository;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $order
     * @return void
     */
    public function handle(OrderCreated $data)
    {
        $products = [];
        foreach ($data->order->products as $product) {
            $products[] = [
                "image" => \RvMedia::getImageUrl($product->product->image),
                "quantity" => (int)$product->qty,
                "variantId" => (string)$product->product->variationInfo->id,
                "productPrice" => (string)$product->product->price,
                "shippingName" => $product->product_name
            ];
        }

        $cjOrder = [
            [
                "customerName" => $data->order->address->first_name. ' ' .$data->order->address->last_name,
                "uid" => (string)$data->order->id,
                "zip" => $data->order->address->zip_code,
                "phone" => $data->order->address->phone,
                "countryCode" => $data->order->address->country,
                "shippingAddress1" => $data->order->address->address,
                "city" => $data->order->address->city,
                "country" => $this->countries[$data->order->address->country],
                "email" => $data->order->address->email,
                "createdAt" => (int)round(microtime(true) * 1000),
                "orderNumber" => (string)$data->order->id,
                "province" => $data->order->address->state,
                "products" => $products
            ]
        ];

        $this->cjDropShippingRepository->createOrders($cjOrder);
    }
}
