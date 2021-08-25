<?php

namespace App\Http\Middleware;

use Botble\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use Closure;
use Illuminate\Http\Request;

class DetectCountry
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * PublicEcommerceController constructor.
     * @param CurrencyInterface $currencyRepository
     */
    public function __construct(CurrencyInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $geoData = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.get_client_ip()));

        if(cms_currency()->getApplicationCurrency()->title != $geoData['geoplugin_currencyCode']) {
            $currency = $this->currencyRepository->getFirstBy(['title' => $geoData['geoplugin_currencyCode']]);
            if ($currency){
                cms_currency()->setApplicationCurrency($currency);
            }
        };

        return $next($request);

    }
}
