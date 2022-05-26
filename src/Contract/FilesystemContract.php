<?php

namespace LocalMailer\Contract;

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
     */
    public function readByDate(string $date): string;

    /**
     * @param string $date
     *
     * @return mixed
     */
    public function getLogPath(string $date);
    
    /**
     * @param string $path
     *
     * @return string
     */
    public function get(string $path): string;

    /**
     * Prepend mail to a log file.
     *
     * @param string $date
     * @param string $content
     * 
     * @return void
     */
    public function prepend(string $date, string $content);
}
