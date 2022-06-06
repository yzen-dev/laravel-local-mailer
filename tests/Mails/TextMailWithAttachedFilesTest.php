<?php

namespace Test\Mails;

use Illuminate\Mail\Mailable;

class TextMailWithAttachedFilesTest extends Mailable
{
    public $subject;
    private string $body;
    
    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->html($this->body)
            ->attach(__DIR__ . '/example.txt');
    }
}
