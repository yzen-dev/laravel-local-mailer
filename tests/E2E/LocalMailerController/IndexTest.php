<?php

namespace E2E\LocalMailerController;

use Illuminate\Support\Facades\Mail;
use LocalMailer\Contract\FilesystemContract;
use Test\Mails\TextMailWithAttachedFilesTest;
use Tests\TestCase;

/**
 * Class IndexTest
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class IndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app(FilesystemContract::class)->deleteDirectory();
    }

    public function testIndex(): void
    {
        $result = $this->get(config('local-mailer.route.prefix'));

        $result->assertOk()
            ->assertViewHas('files');
        $data = $result->getOriginalContent()->getData();
        $this->assertEmpty($data['files']);
        
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest('Test subject', 'test body'));
        Mail::to(['yzen.dev@gmail.com'])->send(new TextMailWithAttachedFilesTest('Test subject', 'test body'));

        $result = $this->get(config('local-mailer.route.prefix'));
        $data = $result->getOriginalContent()->getData();
        
        $this->assertEquals(1, count($data['files']));
        $this->assertEquals(2, $data['files'][0]['count']);
    }
}
