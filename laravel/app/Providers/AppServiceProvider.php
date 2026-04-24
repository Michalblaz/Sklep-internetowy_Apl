<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Product;      
use Illuminate\Pagination\Paginator;       


class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        //
    }

    public function boot(): void
   {
        Paginator::useTailwind();
    }
}
