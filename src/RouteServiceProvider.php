<?php

namespace LocalMailer;

use LocalMailer\Http\Controllers\LocalMailerController;
use LocalMailer\Http\Controllers\LocalMailerResourceController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;

/**
 * Register mailer routes
 */
class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * @return void
     */
    public function map(): void
    {
        /** @phpstan-ignore-next-line */
        $prefix = $this->app['config']->get('local-mailer.route.prefix', 'local-mailer');

        $this->group(
            [
                'prefix' => $prefix,
            ],
            function () {
                $this->get('/', [LocalMailerController::class, 'index'])->name('local-mailer::dashboard');
                $this->get('/{date}', [LocalMailerController::class, 'showByDate'])->name('local-mailer::show-by-date');
                $this->get('/{date}/download', [LocalMailerController::class, 'downloadLog'])->name('local-mailer::download-log');
                $this->get('/{date}/remove', [LocalMailerController::class, 'removeLog'])->name('local-mailer::delete-log');
            }
        );
        $this->group(
            [
                'name' => 'local-mailer::',
                'prefix' => $prefix,
            ],
            function () {
                $this->get('/resource/{file}', [LocalMailerResourceController::class, 'index'])->where('file', '.*')->name('local-mailer::resource');
            }
        );
    }
}
