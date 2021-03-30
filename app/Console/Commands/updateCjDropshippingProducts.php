<?php

namespace App\Console\Commands;

use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Illuminate\Console\Command;
use App\Repositories\CjDropshippingRepository;

class updateCjDropshippingProducts extends Command
{
    /**
     * @var ProductInterface
     */
    protected $productRepository;

    /**
     * @var CjDropshippingRepository
     */
    protected $cjDropshippingRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cj-drop-shipping:update-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Create a new command instance.
     * @param ProductInterface $productRepository
     *
     * @return void
     */
    public function __construct(
        ProductInterface $productRepository,
        CjDropshippingRepository $cjDropshippingRepository
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->cjDropshippingRepository = $cjDropshippingRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = $this->productRepository->getProducts([
            'with'        => [
                'variations',
                'tags',
            ],
        ]);
        foreach ($products as $product) {
        $cjProducts = [];
            $productVariations = [];
            foreach ($product->variations as $variation) {

                    $productVariations[] = [
                        "vid" => (string)$variation->id ,
                        "price" => (string)$variation->product->price,
                        "sku" => $variation->product->sku ,
                        "title" => $variation->product->name ,
                        "grams" => (string)$variation->product->weight ,
                        "oldinventoryquantity" => $variation->product->quantity,
                        "image" => \RvMedia::getImageUrl($variation->product->image)
                ];
            }
            $tags = implode(",",$product->tags->pluck('name')->toArray());
            $cjProducts[] = [
                    "uid" => (string)$product->id ,
                    "title" => $product->name ,
                    "image" => \RvMedia::getImageUrl($product->image),
                    "prices" => (string)$product->price ,
                    "variants" => $productVariations

            ];
            $this->cjDropshippingRepository->addProduct($cjProducts);
        }
    }
}
