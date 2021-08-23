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
//        $currencies = $this->currencyRepository->getAllCurrencies();

//dd($currencies->pluck('title')->toArray());
//        dd($this->currencyLayer->get());
         var_dump($this->get_client_ip());die;
        $curr = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
        'https://api.currencylayer.com/live? access_key = YOUR_ACCESS_KEY& currencies = AUD,CHF,EUR,GBP,PLN';
    }

    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
