<?php


namespace App\Service;
use App\Models\Document;
use Collivery\Macros\FileMacros;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class AppointmentFileService
{
    const XRAY_BASE_LOCATION = 'documents/doctors/xrays/';
    const PRESCRIPTION_BASE_LOCATION = 'documents/doctors/prescriptions/';
    const PRESCRIPTION_TYPE = 1;
    const XRAY_TYPE = 2;

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
        }

        $path = public_path($location);

        if(!File::isDirectory($path)){

            File::makeDirectory($path, 0755, true, true);
        }

        $document_name =  $file->getClientOriginalName();
        $file->move($path ,$document_name);

        return [
            'document_name' => $document_name,
            'document_path' => $document_name,
        ];
    }
    public  function readDocument(int $documentId): array
    {
        try {
            $document = Document::find($documentId);
        } catch (ModelNotFoundException $e) {
            \Flash::error('Document no longer exists');
        }

        $file = $this->getFile($document->document_name, $document->document_path);
        $pageCount = \File::pageCount($file->getPathname());
        $images = \File::getPages($file->getPathname(), FileMacros::QUALITY_HIGH);
        return compact('document', 'file', 'pageCount', 'images', 'documentTypes');
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
