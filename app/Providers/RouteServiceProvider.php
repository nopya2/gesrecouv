<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
        
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/facture.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/user.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/group.php'));
        
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/engagement.php'));
        
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/echelon.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/provider.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/bejcs.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/client.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/web/secteur-activite.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
        
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/user.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/group.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/module.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/echelon.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/provider.php'));
        
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/bejcs.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/client.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/facture.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/paiement.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/secteur-activite.php'));

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/custom/api/relaunch.php'));

    }
}
