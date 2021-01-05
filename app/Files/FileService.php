<?php

namespace App\Files;

use App\Exceptions\FileException;
use App\Exceptions\MethodNotFoundException;
use App\Macros\FileMacros;

/**
 * @method convertToJpeg(string $filePathName) string;
 * @method convertToPng(string $filePathName) string;
 * @method convertToTiff(string $filePathName) string;
 * @method convertToPdf(string $filePathName) string;
 */

class FileService
{
    public $defaultImageType = 'jpeg';

    /**
     * @param string $fullPathName
     * @param int    $page
     * @param int    $resolution
     *
     * @throws \ImagickException
     *
     * @return string binary
     */
    public function getAsBlob($fullPathName, $page = 1, $resolution = FileMacros::QUALITY_MED)
    {
        if (\File::extension($fullPathName) === 'pdf') {
            $image = \File::getPage($fullPathName, $page, $resolution);
        } else {
            $image = \File::getImage($fullPathName, $resolution);
        }
        $image->setFormat($this->defaultImageType);

        return $image->getImageBlob();
    }

    /**
     * @param array|string $fullPathNames
     *
     * @return bool
     */
    public function delete($fullPathNames)
    {
        $success = \File::delete($fullPathNames);
        \Event::dispatch('file.deleted', ['success' => $success, 'files' => $fullPathNames]);

        return $success;
    }

    /**
     * @param array|string $fullPathNames
     *
     * @return bool
     */
    public function softDelete($fullPathNames)
    {
        $success = true;

        foreach ((array) $fullPathNames as $fullPathName) {
            $now = date('Y-m-d H:i:s');
            $name = \File::name($fullPathName);
            $extension = \File::extension($fullPathName);
            $path = \File::dirname($fullPathName);

            $newName = "$name-deleted_$now.$extension";
            $newPath = "$path/deleted";

            $success = $success && strlen($this->move($fullPathName, $newPath, $newName));
        }

        \Event::dispatch('file.soft_deleted', ['success' => $success, 'files' => $fullPathNames]);

        return $success;
    }

    /**
     * @param string $fileBlob
     * @param string $path
     * @param string $fileName
     * @param bool   $base64Encoded
     *
     * @return bool
     */
    public function blobToFile($fileBlob, $path, $fileName, $base64Encoded = false)
    {
        $tmpPath = '/tmp';
        $pathName = $tmpPath.'/'.$fileName;
        $fileBlob = $base64Encoded ? base64_decode($fileBlob) : $fileBlob;
        file_put_contents($pathName, $fileBlob);

        return strlen($this->move($pathName, $path, $fileName));
    }

    public function move(string $fullPathName, string $newPath, string $newName): ?string
    {
        if (!is_dir($newPath)) {
            \File::makeDirectory($newPath, 0755, true);
        }

        $success = \File::move($fullPathName, "$newPath/$newName");

        if ($success) {
            return "$newPath/$newName";
        }

        return null;
    }

    /**
     * @param string $filePathName
     * @param string $format
     *
     * @throws FileException
     * @throws \ImagickException
     *
     * @return string
     */
    public function convert($filePathName, $format)
    {
        $extension = $this->normalizeExtension($format);
        $unNormalised = \File::extension($filePathName);
        $oldExtension = $this->normalizeExtension($unNormalised);

        if ($oldExtension === $extension) {
            return $filePathName;
        }

        $newPathName = str_replace_last($unNormalised, $extension, $filePathName);

        $image = new \Imagick();
        $image->readImage($filePathName);
        $image->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
        $image->setFormat($extension);

        if (\File::pageCount($filePathName) > 1) {
            $newFileWritten = $image->writeImages($newPathName, true);
        } else {
            $newFileWritten = $image->writeImage($newPathName);
        }

        $oldFileDeleted = \File::delete($filePathName);

        if ($newFileWritten && $oldFileDeleted) {
            return $newPathName;
        }

        throw FileException::couldNotConvert($filePathName, $newPathName, $newFileWritten, $oldFileDeleted);
    }

    /**
     * @param string $extension
     *
     * @return string
     */
    private function normalizeExtension($extension)
    {
        // Just in case we passed in a '.'
        $extension = str_replace('.', '', $extension);

        // If there are two spellings, map one to the other
        $extensionMappings = [
            'jpeg' => 'jpg',
            'tif' => 'tiff',
        ];

        if (array_key_exists($extension, $extensionMappings)) {
            return $extensionMappings[$extension];
        }

        return $extension;
    }

    /**
     * Replace absolute paths with relative paths.
     * If the $path is within the storage_path() then
     * strip out all of storage_path,
     * Else strip out base_path.
     *
     * @note return values will start & end with a '/' by default
     *
     * @param string $path    Absolute path withing this laravel base path
     * @param string $prepend
     * @param string $append
     *
     * @return string
     */
    public function relativePath($path, $prepend = '/', $append = '/')
    {
        if (str_contains($path, storage_path())) {
            $search = storage_path().'/';
        } else {
            $search = base_path().'/';
        }

        $replaced = str_replace($search, '', $path);

        return $prepend.$replaced.$append;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @throws MethodNotFoundException
     * @throws \ImagickException
     *
     * @return string
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'convertTo') === false) {
            throw new MethodNotFoundException(self::class." does not have a method called $name");
        }

        $format = strtolower(str_replace('convertTo', '', $name));

        return $this->convert(reset($arguments), $format);
    }
}
