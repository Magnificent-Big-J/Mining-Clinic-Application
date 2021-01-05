<?php

namespace App\Macros;

use Illuminate\Support\Collection;
use App\Exceptions\FileException;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileMacros extends BaseMacro
{
    const QUALITY_LOW = 0;
    const QUALITY_MED = 1;
    const QUALITY_HIGH = 2;

    /**
     * Each Macro loader needs to implement this method to load all macros
     *
     * @throws \ImagickException
     */
    public function register()
    {
        $this->pageCount();
        $this->getImage();
        $this->getPage();
        $this->getPages();
        $this->loadImage();
    }

    /**
     * @param string $pathName
     *
     * @throws \ImagickException
     *
     * @return integer
     */
    public function pageCount($pathName = null)
    {
        \File::macro('pageCount', function ($pathName) {
            if (!file_exists($pathName)) {
                /** @var \File $this */
                // Show full pathName on dev
                $fileName = in_production() ? $this->basename($pathName) : $pathName;
                throw new FileNotFoundException($fileName);
            }
            $image = new \Imagick($pathName);

            return $image->getNumberImages();
        });
    }

    /**
     * @param string $pathName
     * @param int    $pageNumber
     * @param int    $quality
     *
     * @throws \ImagickException
     *
     * @return \Imagick
     */
    public function getPage($pathName = null, $pageNumber = null, $quality = self::QUALITY_MED)
    {
        \File::macro('getPage', function ($pathName, $pageNumber, $quality = \Collivery\Macros\FileMacros::QUALITY_MED) {
            /** @var \File $this */
            if ($this->pageCount($pathName) < $pageNumber) {
                throw FileException::pageNumberNotFound($pathName, $pageNumber);
            }

            return $this->loadImage(sprintf('%s[%d]', $pathName, $pageNumber-1), $quality);
        });
    }

    /**
     * @param string $pathName
     * @param int    $quality
     *
     * @throws \ImagickException
     *
     * @return \Imagick
     */
    public function getImage($pathName = null, $quality = self::QUALITY_MED)
    {
        \File::macro('getImage', function ($pathName, $quality = FileMacros::QUALITY_MED) {
            /** @var \File $this */
            $image = $this->loadImage($pathName, $quality);

            return $image;
        });
    }

    /**
     * @param string $pathName
     * @param int    $quality
     *
     * @throws \ImagickException
     *
     * @return \Illuminate\Support\Collection|\Imagick[]
     */
    public function getPages($pathName = null, $quality = self::QUALITY_MED)
    {
        \File::macro('getPages', function ($pathName, $quality = FileMacros::QUALITY_MED) {
            /** @var \File $this */
            $pageCount = $this->pageCount($pathName);
            $i = 1;
            $files = new Collection();

            while ($i <= $pageCount) {
                $files->push($this->getPage($pathName, $i, $quality));
                $i++;
            }

            return $files;
        });
    }

    /**
     * @param string $pathName
     * @param int    $quality
     *
     * @throws \ImagickException
     *
     * @return \Imagick
     */
    public function loadImage($pathName = null, $quality = null)
    {
        \File::macro('loadImage', function ($pathName, $quality) {
            $image = new \Imagick();
            switch ($quality) {
                case FileMacros::QUALITY_LOW:
                    $image->setResolution(40, 40);
                    $image->readImage($pathName);
                    $image->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
                    $image->mergeImageLayers(\Imagick::LAYERMETHOD_OPTIMIZE);
                    $image->minifyImage();
                    break;
                case FileMacros::QUALITY_MED:
                    $image->setCompression(\Imagick::COMPRESSION_JPEG);
                    $image->setCompressionQuality(60);
                    // Now load the pixels
                    $image->readImage($pathName);
                    break;
                case FileMacros::QUALITY_HIGH:
                    $image->setResolution(200, 200);
                    $image->setCompression(\Imagick::COMPRESSION_LOSSLESSJPEG);
                    $image->setCompressionQuality(80);
                    // Now load the pixels
                    $image->readImage($pathName);
                    $image->setImageResolution(200, 200);
                    break;
            }

            $image->setImageAlphaChannel(\Imagick::VIRTUALPIXELMETHOD_WHITE);
            $image->setFormat('jpeg');

            return $image;
        });
    }
}
