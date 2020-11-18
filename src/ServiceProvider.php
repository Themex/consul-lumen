<?php

namespace Themex\LumenConsul;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\AgentInterface;
use SensioLabs\Consul\Services\CatalogInterface;

class ServiceProvider extends BaseServiceProvider {
    /**
     * Bootstrap app services
     */
    public function boot(): void {
        $this->loadCommands();
    }

    /**
     * Register app services
     */
    public function register() : void
    {
        $this->registerServiceFactory();
        $this->registerCatalogService();
        $this->registerAgentService();
    }

    /**
     * Loading console commands into artisan
     */
    protected function loadCommands(): void {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ServiceRegister::class,
                Commands\ServiceDeregister::class,
                Commands\ServiceList::class
            ]);
        }
    }

    /**
     * Service Factory registration
     */
    protected function registerServiceFactory() {
        $this->app->singleton("consul.service.factory", function () {
            return new ServiceFactory([
                'base_uri' => config('consul.base_uris')[0]
            ]);
        });
    }

    /**
     * CatalogService registration
     */
    protected function registerCatalogService() {
        $this->app->singleton("consul.service.catalog", function () {
            return app("consul.service.factory")->get(CatalogInterface::class);
        });
    }

    /**
     * AgentService registration
     */
    protected function registerAgentService() {
        $this->app->singleton("consul.service.agent", function () {
            return app("consul.service.factory")->get(AgentInterface::class);
        });
    }
}
