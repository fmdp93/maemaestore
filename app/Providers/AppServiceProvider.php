<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
