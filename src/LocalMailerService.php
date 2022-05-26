<?php

namespace LocalMailer;

use LocalMailer\Parser\MailParser;
use LocalMailer\Contract\FilesystemContract;

/**
 * Class LocalMailerService
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class LocalMailerService
{
    /**
     * @var FilesystemContract
     */
    protected FilesystemContract $filesystem;

    /**
     */
    public function __construct(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $filename
     *
     * @return mixed
     */
    private function getDateFromFilename(string $filename)
    {
        $pattern = '/(\d{4}-\d{2}-\d{2})/';
        preg_match($pattern, $filename, $date);
        return $date[0] ?? $filename;
    }

    /**
     * @return array|array[]
     */
    public function getAll(): array
    {
        return array_map(
            function ($log) {
                $parser = new MailParser($this->filesystem->get($log));

                return [
                    'date' => $this->getDateFromFilename($log),
                    'file' => basename($log),
                    'count' => $parser->count(),
                ];
            },
            $this->filesystem->allFiles()
        );
    }

    /**
     * @param string $date
     *
     * @return array<\LocalMailer\Parser\Mail>
     */
    public function getLog(string $date): array
    {
        return (new MailParser($this->filesystem->readByDate($date)))->parse();
        
    }

}
