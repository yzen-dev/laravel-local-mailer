<?php

namespace LocalMailer;

use Swift_Attachment;
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
        $attachment = [];
        foreach ($entity->getChildren() as $child) {
            if ($child instanceof Swift_Attachment) {
                $attachment [] = [
                    'fileName' => $child->getFilename(),
                    'size' => $child->getSize(),
                    'type' => $child->getBodyContentType(),
                    //'body'=>$child->getBody()
                ];
            }
        }

        return json_encode([
            'id' => $this->uuidV4(),
            'body' => $entity->getBody(),
            'subject' => $entity->getSubject(),
            'to' => $entity->getTo(),
            'from' => $entity->getFrom(),
            'date' => date("Y-m-d H:i:s"),
            'attachment' => $attachment
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * Get random UUID
     *
     * @return string UUID
     * @static
     */
    private function uuidV4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
