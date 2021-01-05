<?php

namespace App\Exceptions;

class FileException extends \RuntimeException
{
    /**
     * @param $pathName
     * @param $page
     *
     * @return FileException
     */
    public static function pageNumberNotFound($pathName, $page)
    {
        return new static (
            sprintf(
                'The file provided (%s) does not have %d pages, only %d pages in file.',
                $pathName,
                $page,
                \File::pageCount($pathName)
            )
        );
    }

    /**
     * @param $oldPathName
     * @param $newPathName
     * @param $newFileWritten
     * @param $oldFileDeleted
     *
     * @return FileException
     */
    public static function couldNotConvert($oldPathName, $newPathName, $newFileWritten, $oldFileDeleted)
    {
        $oldName = basename($oldPathName);
        $newName = basename($newPathName);

        if (!$newFileWritten) {
            $reason[] = 'could not write new file';
        }

        if (!$oldFileDeleted) {
            $reason[] = 'could not delete old file';
        }

        if (!$newFileWritten && !$oldFileDeleted) {
            $reason = implode(' and ', $reason);
        } elseif (!$newFileWritten || !$oldFileDeleted) {
            $reason = implode('', $reason);
        }

        return new static(
            sprintf(
                'Could not convert the file from %s to $s, because %s',
                $oldName, $newName, $reason
            )
        );
    }
}
