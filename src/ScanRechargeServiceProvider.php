<?php

namespace Qihucms\ScanRecharge;

use Illuminate\Support\ServiceProvider;

class ScanRechargeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'scan-recharge');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'scan-recharge');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/scan-recharge'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/scan-recharge'),
        ]);
    }
}
