<?php


namespace App\Service;

use App\Models\Document;
use App\Macros\FileMacros;
use App\Files\FileService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;
use SplFileInfo;
class AppointmentFileService extends FileService
{
    const XRAY_BASE_LOCATION = 'documents/doctors/xrays/';
    const PRESCRIPTION_BASE_LOCATION = 'documents/doctors/prescriptions/';
    const REFERRALS_BASE_LOCATION = 'documents/doctors/referrals/';
    const PRESCRIPTION_TYPE = 1;
    const XRAY_TYPE = 2;
    const REFERRALS_TYPE = 3;

    public  function storeFile(UploadedFile $file, int $type, int $practice_number) : array
    {
        $location = null;
        switch ($type) {
            case self::PRESCRIPTION_TYPE:
                    $location = self::PRESCRIPTION_BASE_LOCATION . $practice_number;
                break;
            case self::XRAY_TYPE:
                    $location = self::XRAY_BASE_LOCATION . $practice_number;
                break;
            case self::REFERRALS_TYPE:
                    $location = self::REFERRALS_BASE_LOCATION;
                break;
        }

        $path = public_path($location);

        if(!File::isDirectory($path)){

            File::makeDirectory($location, 0755, true, true);
        }
        $document_name =  preg_replace('/\s+/', '_', $file->getClientOriginalName());

        $file->move($location, $document_name);

        return [
            'document_name' => $document_name,
            'document_path' => $location,
        ];
    }
    public  function readDocument(int $documentId): array
    {
        try {
            $document = Document::find($documentId);
        } catch (ModelNotFoundException $e) {
            \Flash::error('Document no longer exists');
        }

        try {
            $file = $this->getFile($document->document_name, $document->document_path);

        } catch (FileNotFoundException $e) {
        }
        try {
            $pageCount = 1;
        } catch (\ImagickException $e) {
        }
        try {
            $images = 'Hello';
        } catch (\ImagickException $e) {
        }
        return compact('document', 'file', 'pageCount', 'images');
    }

    private function getFile(string $fileName, string $location): SplFileInfo
    {
        $fileIterator = Finder::create()
            ->in($location)
            ->files()
            ->depth(0)
            ->name($fileName)
            ->getIterator();

        $fileIterator->rewind();
        /** @var SplFileInfo $file */
        $file = $fileIterator->current();

        if (!$file) {
            throw new FileNotFoundException("File {$fileName} not found at {$location}");
        }

        return $file;
    }
}
