<?php

namespace LocalMailer\Parser;

/**
 * Class Mail
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class Mail
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $subject;

    /**
     * @var mixed
     */
    public $from;

    /**
     * @var mixed
     */
    public $to;

    /**
     * @var string
     */
    public string $date;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var array
     */
    public array $attachment =[];

    /**
     * @param array<mixed> $args
     */
    public function __construct(array $args)
    {
        $this->id = $args['id'];
        $this->subject = $args['subject'];
        $this->from = $args['from'];
        $this->to = $args['to'];
        $this->date = $args['date'];
        $this->body = $args['body'];
        $this->attachment = $args['attachment'];
    }
}
