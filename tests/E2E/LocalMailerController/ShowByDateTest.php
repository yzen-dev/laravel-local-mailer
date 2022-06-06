<?php

namespace E2E\LocalMailerController;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use LocalMailer\Contract\FilesystemContract;
use Test\Mails\TextMailWithAttachedFilesTest;

/**
 * Class ShowByDateTest
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class ShowByDateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app(FilesystemContract::class)->deleteDirectory();
    }

    public function testNotFound(): void
    {
        $this->get(config('local-mailer.route.prefix') . '/' . date("Y-m-d"))
            ->assertOk()
            ->assertViewIs('local-mailer::not-found');
    }

    public function testIndex(): void
    {
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest('Test subject', 'test body'));
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest('Test subject', 'test body'));

        $result = $this->get(config('local-mailer.route.prefix') . '/' . date("Y-m-d"));
        $data = $result->getOriginalContent()->getData();
        $this->assertEquals(date("Y-m-d"), $data['date']);
        $this->assertEquals(2, count($data['mails']));
    }
}
