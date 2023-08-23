<?php

namespace App\Providers;

use App\Services\TestService;
use App\Services\TestServiceToFacade;
use App\UseCases\MessangerNotificatorInterface;
use App\UseCases\TelegramNotificator;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function() {
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));
            return $faker;
        });

        $this->app->bind(TestService::class, function () {
            return new TestService(true);
        });

        $this->app->bind(MessangerNotificatorInterface::class, TelegramNotificator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFour();
        //$this->app->singleton(TestServiceToFacade::class, function () {
        //
        //    return new TestServiceToFacade('token123');
        //});

    }
}
