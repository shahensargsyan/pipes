<?php

namespace App\Console\Commands;

use App\Repositories\CjDropshippingRepository;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Illuminate\Console\Command;

class deleteCjDropshippingProducts extends Command
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
    protected $signature = 'cj-drop-shipping:delete-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Products';


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
            $cjProducts = [
                (string)$product->id
            ];

            $this->cjDropshippingRepository->deleteShopProducts($cjProducts);
        }
    }
}
