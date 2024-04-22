<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use App\Faker\Provider\ProductProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function () {
            $faker = FakerFactory::create();
            $faker->addProvider(new ProductProvider($faker));
            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->useHttps();
        Paginator::useBootstrap();
        Password::defaults(function () {
            $rules = Password::min(4)
                ->letters()
                ->numbers();
                
            return $rules;
        });
        // Paginator::defaultView('components.pagination');
    }

    private function useHttps(){
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
