<?php

namespace Tests\Feature;

use Tests\TestCase;
use LocalMailer\LocalMailerService;
use Illuminate\Support\Facades\Mail;
use LocalMailer\Contract\FilesystemContract;
use Test\Mails\TextMailWithAttachedFilesTest;

class SendAttachedFilesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app(FilesystemContract::class)->deleteDirectory();
    }

    /**
     * @return void
     */
    public function testWriter()
    {
        $subject = 'New message';
        $body = '<h1>Test message!</h1>';
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest($subject, $body));
        $path = app(FilesystemContract::class)->getFormatterPath(date("Y-m-d"));
        $this->assertFileExists($path);

        $log = app(LocalMailerService::class)->getLog(date("Y-m-d"));
        $this->assertIsArray($log);
        $mail = array_pop($log);
        $this->assertEquals($subject, $mail->subject);
        $this->assertEquals($body, $mail->body);
    }
}
