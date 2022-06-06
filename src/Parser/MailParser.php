<?php

namespace LocalMailer\Parser;

/**
 * Class MailParser
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class MailParser
{
    /**
     * Mail log separator regex
     */
    private const PATTERN = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] MAIL:\n/';

    /**
     * @var string $content File content
     */
    private string $content;

    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }


    /**
     * @return array<\LocalMailer\Parser\Mail>
     */
    public function parse(): array
    {
        $mailLogs = preg_split(self::PATTERN, $this->content);
        $mailLogs = array_filter((array)$mailLogs);

        return array_map(
            static fn($mail) => new Mail(json_decode($mail, true)),
            $mailLogs
        );
    }

    /**
     * Get count mails in file
     *
     * @return int
     */
    public function count()
    {
        preg_match_all(self::PATTERN, $this->content, $headings);
        if (isset($headings[1])) {
            return count($headings[1]);
        }
        return 0;
    }
}
