<?php

namespace App\Providers;

use App\Models\DocumentRequest;
use App\Observers\DocumentRequestObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        DocumentRequest::observe(DocumentRequestObserver::class);
    }
}
