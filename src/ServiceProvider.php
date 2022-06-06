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

        $this->app->singleton(FilesystemContract::class, function ($app) {
            return new Filesystem($app['files'], $app['path.storage']);
        });

        $this->app->singleton(MailLoggerContract::class, function ($app) {
            return new MailerLogger($app->make(FilesystemContract::class));
        });
        
        $this->loadViewsFrom(__DIR__ . '/views', 'local-mailer');

        $this->mergeConfigFrom(__DIR__ . '/config/local-mailer.php', 'local-mailer');
        
        if ($this->app['config']->get('local-mailer.route.enabled', false)){
            $this->app->register(RouteServiceProvider::class);
        }
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
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->publishes(
            [
                /* @phpstan-ignore-next-line */
                __DIR__ . '/config/local-mailer.php' => config_path('local-mailer.php'),
            ],
            'config'
        );
        
        Mail::extend('local-mailer', function () {
            return new LocalMailerTransport($this->app->make(MailLoggerContract::class));
        });
    }

}
