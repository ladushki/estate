<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laraplus\Form\Presenters\BasePresenter;
use Laraplus\Form\Presenters\Bootstrap4Presenter;

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
        Blade::directive('money', function ($amount) {
            return "<?php echo ' £' . number_format($amount, 0); ?>";
        });
    }
}
