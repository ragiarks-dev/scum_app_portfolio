<?php

namespace App\Http\Controllers;

use App\Common\ScumLog;
use App\Service\ScumLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class ScumLogController extends BaseController
{
    private ScumLog $scumLog;
    private ScumLogService $scumLogService;

    #[Pure] public function __construct(ScumLog $scumLog, ScumLogService $scumLogService)
    {
        parent::__construct();
        $this->scumLog = $scumLog;
        $this->scumLogService = $scumLogService;
    }

    public function logFileModelUpdate(Request $request): JsonResponse
    {
        $fileType = $request->get('file_type');
        $logFileModel = $this->scumLogService->getNewestLogFile($fileType);

        if (!$logFileModel){
            $this->response['message'] = [$fileType . ' ログファイルモデルが見つかりませんでした。'];
            return response()->json($this->response, 404);
        }

        $this->scumLog->logFileModelUpdate($fileType, $logFileModel->file_date);

        $this->response['message'] = [$fileType . ' ログファイルモデルの更新が完了しました。'];
        return response()->json($this->response);
    }
}
