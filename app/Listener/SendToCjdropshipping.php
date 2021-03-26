<?php

namespace App\Listener;

use App\Event\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\CjDropshippingRepository;

class SendToCjdropshipping
{
    public $cjDropShippingRepository;

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

//        dd($data->order->address->first_name);
        $products = [];
        foreach ($data->order->products as $product) {
            $products[] = [
                "image" => \RvMedia::getImageUrl($product->product->image),
                "quantity" => (int)$product->qty,
                "variantId" => "71" ,
                "productPrice" => $product->product->price,
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
                "country" => $data->order->address->country,
                "email" => $data->order->address->email,
                "createdAt" => now()->timestamp,
                "orderNumber" => (string)$data->order->id,
                "province" => $data->order->address->state,
                "products" => $products
            ]
        ];
        var_dump(now()->timestamp);
//        echo (json_encode($cjOrder, JSON_UNESCAPED_SLASHES));die;

        '[
            {
                "customerName":"Drert Dfggh",
                "uid":"55",
                "zip":"wer",
                "phone":"345345",
                "countryCode":"AT",
                "shippingAddress1":"sdfsdf",
                "city":"sdf",
                "country":"AT",
                "email":"sdf@sfsf.sdf",
                "createdAt":1534318375082,
                "createdAt":1616679014,
                "createdAt":1534318375082,
                "createdAt":1616740913,
                "orderNumber":"55",
                "province":"sdfsf",
                    "products":[
                        {
                            "image":"http://board-main.loc/storage/products/product-5-at-2x.png",
                            "quantity":"1",
                            "variantId":"71",
                            "productPrice":12345678,
                            "shippingName":"test testtest"
                        }
                    ]
                }
            ]';


        $this->cjDropShippingRepository->createOrders(json_encode($cjOrder, JSON_UNESCAPED_SLASHES));
        die;
    }
}
