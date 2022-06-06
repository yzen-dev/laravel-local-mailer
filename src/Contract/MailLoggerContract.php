<?php

namespace LocalMailer\Contract;

/**
 * Class MailLoggerContract
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
interface MailLoggerContract
{
    /**
     * @param string $mail
     *
     * @return void
     */
    public function write(string $mail);
}
