<?php

namespace Tests;

use LocalMailer\Contract\FilesystemContract;
use LocalMailer\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class TestCase
 *
 * @package Tests
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var MockObject|Filesystem
     */
    protected $fileSystem;

    /**
     * @before
     *
     * @return void
     */
    public function setUpFileSystem(): void
    {
        $this->fileSystem = $this->createMock(Filesystem::class);
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('mail.default', 'local-mailer');
        $app['config']->set('mail.mailers.local-mailer', [
            'transport' => 'local-mailer'
        ]);
        
        $app['config']->set('filesystems.default', 'local');
        $app['config']->set('filesystems.disks.local.root', realpath(__DIR__.'/storage'));
        $app['config']->set('path.storage', realpath(__DIR__.'/storage'));
        app(FilesystemContract::class)->setPath(realpath(__DIR__.'/storage'));
    }
}
