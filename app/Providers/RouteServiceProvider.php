<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            //default
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            //Api - Authentication
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Authentication/authentication.php'));

            //Api - Company
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/company.php'));
            //Api - Permission
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/permission.php'));
            //Api - Role
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/role.php'));
            //Api - Menu
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/menu.php'));
            //Api - Users
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/user.php'));
            //Api - Inventory
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/inventory.php'));
            //Api - Third
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/third.php'));
            //Api - Sale
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/Admin/sale.php'));
            //Api - Dashboard
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Api/dashboard.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
