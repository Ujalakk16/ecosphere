<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS for all assets
    if ($this->app->environment('production') || request()->secure()) {
        URL::forceScheme('https');
    }
        // Tailwind pagination ke liye
        Paginator::useTailwind();

        // Cart count ko poori website (har view) mein bhejne ke liye
        View::composer('*', function ($view) {
            $cart = Session::get('cart', []);
            // Agar aapke cart mein products count ho rahe hain
            $view->with('cartCount', is_array($cart) ? count($cart) : 0);
        });
    
{
    \Illuminate\Support\Facades\Blade::directive('trans', function ($expression) {
        return "<?php echo \App\Helpers\TranslationHelper::translate($expression, session('locale', 'ur')); ?>";
    });
}
    }
}