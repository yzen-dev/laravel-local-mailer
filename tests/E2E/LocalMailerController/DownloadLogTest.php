<?php

namespace E2E\LocalMailerController;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use LocalMailer\Contract\FilesystemContract;
use Test\Mails\TextMailWithAttachedFilesTest;

/**
 * Class DownloadLogTest
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class DownloadLogTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app(FilesystemContract::class)->deleteDirectory();
    }

    public function testNotFound(): void
    {
        $this->get(config('local-mailer.route.prefix') . '/2000-01-01/download')
            ->assertOk()
            ->assertViewIs('local-mailer::not-found');
    }

    public function testIndex(): void
    {
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest('Test subject', 'test body'));
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest('Test subject', 'test body'));

        $this->get(config('local-mailer.route.prefix') . '/' . date("Y-m-d") . '/download')
            ->assertDownload();
    }
}
