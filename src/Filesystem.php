<?php

namespace LocalMailer;

use LocalMailer\Contract\FilesystemContract;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;

/**
 * Class Filesystem
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
class Filesystem implements FilesystemContract
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The base storage path.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * Filesystem constructor.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param string $storagePath
     */
    public function __construct(IlluminateFilesystem $files, $storagePath)
    {
        $this->filesystem = $files;
        $this->setPath($storagePath);
    }

    /**
     * Set the log storage path.
     *
     * @param string $storagePath
     *
     * @return $this
     */
    public function setPath(string $storagePath): Filesystem
    {
        $this->storagePath = $storagePath;

        return $this;
    }

    /**
     * Get all log files.
     *
     * @return array<string>
     */
    public function allFiles(): array
    {
        return $this->filesystem->glob($this->storagePath . DIRECTORY_SEPARATOR . 'mails' . DIRECTORY_SEPARATOR . '*.log');
    }

    /**
     * Get log file.
     *
     * @param string $path
     *
     * @return string
     */
    public function get(string $path): string
    {
        try {
            $log = $this->filesystem->get($path);
        } catch (\Exception $e) {
            throw new \RuntimeException('File not found');
        }

        return $log;
    }

    /**
     * Read the emails.
     *
     * @param string $date
     *
     * @return string
     */
    public function readByDate(string $date): string
    {
        try {
            $log = $this->filesystem->get(
                $this->getLogPath($date)
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('File not found');
        }

        return $log;
    }

    /**
     * Get the log file path.
     *
     * @param string $date
     *
     * @return string|false
     */
    public function getLogPath(string $date): string
    {
        $path = $this->storagePath . DIRECTORY_SEPARATOR . 'mails' . DIRECTORY_SEPARATOR . 'mails-' . $date . '.log';

        if (!$this->filesystem->exists($path)) {
            throw new \RuntimeException('File not found');
        }

        return realpath($path);
    }

    /**
     * Prepend mail to a log file.
     *
     * @param string $date
     * @param string $content
     */
    public function prepend(string $date, string $content)
    {
        $path = $this->storagePath . DIRECTORY_SEPARATOR . 'mails' . DIRECTORY_SEPARATOR . 'mails-' . $date . '.log';

        $this->filesystem->prepend($path, $content);
    }
}
