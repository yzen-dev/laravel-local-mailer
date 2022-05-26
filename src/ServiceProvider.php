<?php

namespace LocalMailer;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LocalMailer\Contract\FilesystemContract;
use LocalMailer\Contract\MailLoggerContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package LaravelWebKit
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();
        try {
            $this->createLocalMailer();
        } catch (\Throwable $exception) {
            dd($exception);
        }
        $this->app->register(RouteServiceProvider::class);
        $this->loadViewsFrom(__DIR__ . '/views', 'local-mailer');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [
            FilesystemContract::class,
        ];
    }

    /**
     * @return void
     */
    protected function createLocalMailer()
    {
        $this->app->singleton(FilesystemContract::class, function ($app) {
            return new Filesystem($app['files'], $app['path.storage']);
        });

        $this->app->singleton(MailLoggerContract::class, function ($app) {
            return new MailerLogger($app->make(FilesystemContract::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        Mail::extend('local-mailer', function () {
            return new LocalMailerTransport($this->app->make(MailLoggerContract::class));
        });
    }

}
