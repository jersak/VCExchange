<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Transaction;
use App\Observers\TransactionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Transaction::observe(TransactionObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
