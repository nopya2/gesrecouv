<?php

namespace App\Providers;

use App\Engagement;
use App\Echelon;
use App\Paiement;
use App\Facture;
use App\Observers\EngagementObserver;
use App\Observers\EchelonObserver;
use App\Observers\PaiementObserver;
use App\Observers\FactureObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Engagement::observe(EngagementObserver::class);
        Echelon::observe(EchelonObserver::class);
        Paiement::observe(PaiementObserver::class);
        Facture::observe(FactureObserver::class);
    }
}
