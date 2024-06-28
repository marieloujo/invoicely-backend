<?php

namespace App\Providers;

use App\Models\Facture;
use App\Models\Product;
use App\Models\Service;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-product', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('manage-service', function (User $user, Service $service) {
            return $user->id === $service->user_id;
        });

        Gate::define('manage-supply', function (User $user, Supply $supply) {
            return $user->id === $supply->user_id;
        });

        Gate::define('manage-facture', function (User $user, Facture $facture) {
            return $user->id === $facture->user_id;
        });
    }
}
