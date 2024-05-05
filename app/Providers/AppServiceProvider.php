<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use App\Models\User;
use App\Models\Voucher;
use App\Policies\VoucherPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(UserRegistered::class, SendWelcomeEmail::class);

        Gate::define('delete-voucher', [VoucherPolicy::class, 'isOwner']);

        Gate::define('view-voucher', [VoucherPolicy::class, 'isOwner']);
    }
}
