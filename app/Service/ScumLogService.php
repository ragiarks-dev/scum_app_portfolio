<?php

namespace App\Service;

use App\Models\LogFiles;

class ScumLogService
{
    public function getNewestLogFile($fileType)
    {
        return LogFiles::where('file_type', $fileType)
            ->latest()
            ->first();
    }

    public function createLogFileModel($fileName, $fileType, $fileDate): int
    {
        $logFile = LogFiles::create([
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_date' => $fileDate,
        ]);

        if (!$logFile){
            return 500;
        }

        return 200;
    }
}
