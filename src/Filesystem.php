<?php

namespace LocalMailer;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
     * @throws FileNotFoundException
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
     * @return string
     * @throws FileNotFoundException
     */
    public function getLogPath(string $date): string
    {
        $path = $this->storagePath . DIRECTORY_SEPARATOR . 'mails' . DIRECTORY_SEPARATOR . 'mails-' . $date . '.log';

        if (!$this->filesystem->exists($path)) {
            throw new FileNotFoundException('File ' . $path . ' not found');
        }

        return realpath($path);
    }

    /**
     * Prepend mail to a log file.
     *
     * @param string $date
     * @param string $content
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function prepend(string $date, string $content)
    {
        $this->filesystem->prepend($this->getLogPath($date), $content);
    }

    /**
     * Remove log file.
     *
     * @param string $date
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function delete(string $date): bool
    {
        return $this->filesystem->delete($this->getLogPath($date));
    }
}