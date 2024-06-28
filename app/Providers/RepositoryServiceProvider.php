<?php

namespace App\Providers;

use App\Repositories\ClientRepository;
use App\Repositories\FactureRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SupplyRepository;
use App\Services\AuthenticationService;
use App\Services\ClientService;
use App\Services\FactureService;
use App\Services\Interfaces\AuthenticationServiceInterface;
use App\Services\Interfaces\ClientServiceInterface;
use App\Services\Interfaces\FactureServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\ServiceServiceInterface;
use App\Services\Interfaces\SupplyServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use App\Services\ProductService;
use App\Services\ServiceService;
use App\Services\SupplyService;
use App\Services\TransactionService;
use Core\Repository\BaseRepository;
use Core\Repository\EloquentRepositoryInterface;
use Core\Services\AbstractCrudService;
use Core\Services\AbstractCrudServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, SupplyRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, FactureRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, ServiceRepository::class);


        $this->app->bind(AbstractCrudServiceInterface::class, AbstractCrudService::class);
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(SupplyServiceInterface::class, SupplyService::class);
        $this->app->bind(FactureServiceInterface::class, FactureService::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
        $this->app->bind(ServiceServiceInterface::class, ServiceService::class);

    }

}
