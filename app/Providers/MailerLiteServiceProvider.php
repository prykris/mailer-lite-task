<?php

namespace App\Providers;

use App\Services\MailerLiteService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MailerLiteServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MailerLiteService::class, function (): ?MailerLiteService {
            return new MailerLiteService(null);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(MailerLiteService $mailerLiteService): void
    {
        View::share('mailerLiteService', $mailerLiteService);
    }

    public function provides(): array
    {
        return [MailerLiteService::class];
    }

}
