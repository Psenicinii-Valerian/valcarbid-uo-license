<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
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
        Paginator::useBootstrap();

        // Format a whole number with a thousands separator, used for both
        // prices and mileage (e.g. 1.000, 100.000, 78.450)
        Blade::directive('thousands', function ($expression) {
            return "<?php echo number_format((float) ($expression), 0, ',', '.'); ?>";
        });
    }
}
