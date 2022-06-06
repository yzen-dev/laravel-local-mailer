<?php

namespace E2E\LocalMailerResourceController;

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

    public function testNotFound(): void
    {
        $this->get(config('local-mailer.route.prefix') . '/resource/css/fake.css')
            ->assertNotFound();
    }
    
    public function testIndex(): void
    {
        $this->get(config('local-mailer.route.prefix') . '/resource/css/styles.css')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/css; charset=UTF-8');
    }
}
