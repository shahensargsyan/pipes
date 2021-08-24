<?php

namespace App\Console\Commands;

use Botble\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Illuminate\Console\Command;
use App\Repositories\CurrencyLayerRepository;

class UpdateCurrencyRates extends Command
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;
    /**
     * @var CurrencyLayerRepository
     */
    protected $currencyLayer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     * @param CurrencyLayerRepository $currencyLayer
     * @param CurrencyInterface $currencyRepository
     * @return void
     */
    public function __construct(CurrencyLayerRepository $currencyLayer, CurrencyInterface $currencyRepository)
    {
        parent::__construct();
        $this->currencyLayer = $currencyLayer;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currencies = $this->currencyRepository->getAllCurrencies();
        $liveCurrencies = $this->currencyLayer->get();

         foreach ($currencies as $currency) {
             if ($currency->is_default)
                 continue;

            $currency->exchange_rate = $liveCurrencies['quotes']['USD'.$currency->title];
            $currency->save();
        }
    }
}
