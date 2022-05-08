<?php

namespace Royalcms\Component\Excel\Facades;

use Illuminate\Contracts\Queue\ShouldQueue;
use Royalcms\Component\Support\Facades\Facade;

/**
 *
 * Royalcms Excel Facade
 *
 * @method static download($export, string $fileName, string $writerType = null, array $headers = [])
 * @method static store($export, string $filePath, string $diskName = null, string $writerType = null, $diskOptions = [])
 * @method static queue($export, string $filePath, string $disk = null, string $writerType = null, $diskOptions = [])
 * @method static raw($export, string $writerType)
 * @method static import($import, $filePath, string $disk = null, string $readerType = null)
 * @method static toArray($import, $filePath, string $disk = null, string $readerType = null)
 * @method static toCollection($import, $filePath, string $disk = null, string $readerType = null)
 * @method static queueImport(ShouldQueue $import, $filePath, string $disk = null, string $readerType = null)
 * @method static export($export, string $fileName, string $writerType = null)
 */
class Excel extends Facade
{

    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'excel';
    }

}