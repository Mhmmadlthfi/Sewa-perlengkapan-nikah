<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

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
        View::composer('*', function ($view) {
            $title = $view->getData()['title'] ?? $this->getTitleFromUrl();
            $brandName = 'Karisma Arga';
            $view->with('pageTitle', "$title | $brandName");
        });

        Blade::directive('rupiah', function ($expression) {
            return "<?php echo isset($expression) ? 'Rp ' . number_format($expression, 0, ',', '.') : 'Rp 0'; ?>";
        });
    }

    protected function getTitleFromUrl()
    {
        $urlMap = [
            'category*' => 'Kategori',
            'product*' => 'Produk',
            'order*' => 'Order',
            'user*' => 'Pengguna',
        ];

        foreach ($urlMap as $pattern => $title) {
            if (Request::is($pattern)) {
                return $title;
            }
        }

        return 'Dashboard';
    }
}
