<?php

namespace LocalMailer;

use LocalMailer\Contract\MailLoggerContract;

/**
 *
 */
class MailerLogger implements MailLoggerContract
{
    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $mail
     *
     * @return void
     */
    public function write(string $mail)
    {
        $this->filesystem->prepend(date("Y-m-d"), $mail);
    }
}
