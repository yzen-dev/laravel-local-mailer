<?php

namespace LocalMailer;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
     * @param FilesystemContract $filesystem
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
     * @return array<array>
     * @throws FileNotFoundException
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
     * @throws FileNotFoundException
     */
    public function getLog(string $date): array
    {
        return (new MailParser($this->filesystem->readByDate($date)))->parse();
    }

    /**
     * @param string $date
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getPathByDate(string $date): string
    {
        return $this->filesystem->getLogPath($date);
    }

    /**
     * @param string $date
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function delete(string $date): bool
    {
        return $this->filesystem->delete($date);
    }
}
