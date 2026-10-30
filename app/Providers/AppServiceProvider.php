<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Setting;
use App\Models\TrainingRegistration;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale(config('app.locale', 'id'));

        Paginator::defaultView('partials.pagination');

        // Pengaturan situs tersedia di semua view sebagai $site
        View::composer('*', function ($view) {
            static $site = null;
            if ($site === null) {
                try {
                    $site = Setting::allValues();
                } catch (Throwable) {
                    $site = Setting::defaults();
                }
            }
            $view->with('site', $site);
        });

        // Lencana jumlah item baru di menu admin
        View::composer('admin.layout', function ($view) {
            $view->with('badges', [
                'messages' => Message::where('status', 'new')->count(),
                'registrations' => TrainingRegistration::where('status', 'pending')->count(),
            ]);
        });
    }
}
