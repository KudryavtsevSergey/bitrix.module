<?php

namespace Sun\BitrixModule\Utils;

use Sun\BitrixModule\Exception\InternalError;

class DirUtils
{
    private const CURRENT_DIRECTORY = '.';
    private const PARENT_DIRECTORY = '..';
    private const DIRECTORY_PERMISSIONS = 0777;

    public static function removeDirectory(string $path): void
    {
        if (is_dir($path)) {
            $objects = scandir($path);
            foreach ($objects as $object) {
                if ($object !== self::CURRENT_DIRECTORY && $object !== self::PARENT_DIRECTORY) {
                    $filename = $path . DIRECTORY_SEPARATOR . $object;
                    if (is_dir($filename) && !is_link($filename)) {
                        self::removeDirectory($filename);
                    } elseif (!unlink($filename)) {
                        throw new InternalError(sprintf('Error removing %s file', $filename));
                    }
                }
            }
            if (!rmdir($path)) {
                throw new InternalError(sprintf('Error removing %s directory', $path));
            }
        }
    }

    public static function createDirectory(string $directory, bool $throwIfExist = true): void
    {
        if (file_exists($directory)) {
            if ($throwIfExist) {
                throw new InternalError(sprintf('File %s already exist', $directory));
            }
        } elseif (!mkdir($directory, self::DIRECTORY_PERMISSIONS, true)) {
            $error = self::getLastErrorAsString();
            throw new InternalError(sprintf('Error creating %s with error: %s', $directory, $error));
        }
    }

    private static function getLastErrorAsString(): ?string
    {
        $error = error_get_last();
        $type = $error['type'] ?? null;
        $message = $error['message'] ?? null;
        $file = $error['file'] ?? null;
        $line = $error['line'] ?? null;
        return $message === null ? null : sprintf(
            'type: %s, message: %s, file: %s, line: %s',
            $type,
            $message,
            $file,
            $line
        );
    }

    public static function reCreateDirectory(string $target): void
    {
        self::removeDirectory($target);
        self::createDirectory($target);
    }

    public static function copyDirectory(string $pathFrom, string $pathTo)
    {
        self::reCreateDirectory($pathTo);

        if (!$sourceDirectoryHandle = opendir($pathFrom)) {
            throw new InternalError(sprintf('The %s directory does not exists!', $pathFrom));
        }

        while (($entry = readdir($sourceDirectoryHandle)) !== false) {
            if ($entry == DirUtils::CURRENT_DIRECTORY || $entry == DirUtils::PARENT_DIRECTORY) {
                continue;
            }

            $sourcePath = sprintf('%s/%s', $pathFrom, $entry);
            $targetPath = sprintf('%s/%s', $pathTo, $entry);
            $sourceStat = lstat($sourcePath);
            if ($sourceStat === false) {
                throw new InternalError(sprintf('Cannot stat %s', $sourcePath));
            }

            switch (true) {
                case is_link($sourcePath):
                    break;
                case is_dir($sourcePath):
                    self::copyDirectory($sourcePath, $targetPath);
                    break;
                case is_file($sourcePath):
                    if (!copy($sourcePath, $targetPath)) {
                        throw new InternalError(sprintf('Cannot copy from %s to %s', $sourcePath, $targetPath));
                    }
                    touch($targetPath, $sourceStat['mtime']);
                    chmod($targetPath, $sourceStat['mode']);
                    chgrp($targetPath, $sourceStat['gid']);
                    chown($targetPath, $sourceStat['uid']);
                    break;
                default:
                    throw new InternalError(sprintf('Unable to determine the file type for %s', $sourcePath));
            }
        }
        closedir($sourceDirectoryHandle);
    }
}
