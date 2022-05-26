<?php

namespace LocalMailer;

use Swift_Mime_SimpleMessage;
use Illuminate\Mail\Transport\Transport;
use LocalMailer\Contract\MailLoggerContract;

class LocalMailerTransport extends Transport
{
    /**
     * The Logger instance.
     *
     * @var MailLoggerContract
     */
    protected MailLoggerContract $logger;

    /**
     * Create a new log transport instance.
     *
     * @param MailLoggerContract $logger
     *
     */
    public function __construct(MailLoggerContract $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     * @throws \JsonException
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null): int
    {
        $this->beforeSendPerformed($message);

        $this->logger->write(
            '[' . date("Y-m-d H:i:s") . '] MAIL:' . PHP_EOL .
            $this->prepareMail($message) . PHP_EOL
        );

        $this->sendPerformed($message);
        return $this->numberOfRecipients($message);
    }

    /**
     * Get a loggable string out of a swift message entity.
     *
     * @param \Swift_Mime_SimpleMessage $entity
     *
     * @return string
     * @throws \JsonException
     */
    protected function prepareMail(Swift_Mime_SimpleMessage $entity)
    {
        return json_encode([
            'body' => $entity->getBody(),
            'subject' => $entity->getSubject(),
            'to' => $entity->getTo(),
            'from' => $entity->getFrom(),
            'date' => date("Y-m-d H:i:s"),
        ], JSON_THROW_ON_ERROR);
    }

}
