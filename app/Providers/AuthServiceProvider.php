<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Filament\Facades\Filament;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Filament::serving(function () {
            if (auth()->check() && !auth()->user()->hasAnyRole(['admin', 'seller'])) {
                abort(403);
            }
        });
    }
}
