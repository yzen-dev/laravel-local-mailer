<?php

namespace LocalMailer\Contract;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * Class FilesystemContract
 *
 * @author yzen.dev <yzen.dev@gmail.com>
 */
interface FilesystemContract
{
    /**
     * @param string $storagePath
     *
     * @return mixed
     */
    public function setPath(string $storagePath);

    /**
     * @return array<string>
     */
    public function allFiles(): array;

    /**
     * @param string $date
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function readByDate(string $date): string;

    /**
     * @param string $date
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getLogPath(string $date): string;

    /**
     * @param string $path
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function get(string $path): string;

    /**
     * Prepend mail to a log file.
     *
     * @param string $date
     * @param string $content
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function prepend(string $date, string $content);

    /**
     * Delete log file.
     *
     * @param string $date
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function delete(string $date): bool;

    /**
     * Get the log dir.
     *
     * @return string
     */
    public function getDir();
}
