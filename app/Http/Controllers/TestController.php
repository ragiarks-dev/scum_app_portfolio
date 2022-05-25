<?php

namespace App\Http\Controllers;

use App\Common\Api;
use App\Common\Methods;
use App\Common\ScumLog;
use App\Service\KillLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    private ScumLog $scumLog;
    private KillLogService $killLogService;
    private Methods $methods;
    private Api $api;

    public function __construct(ScumLog $scumLog, KillLogService $killLogService, Methods $methods, Api $api){
        $this->scumLog = $scumLog;
        $this->killLogService = $killLogService;
        $this->methods = $methods;
        $this->api = $api;
    }

    public function test()
    {
        try{
            $this->scumLog->getKillLog(); //キルログファイルからログの取得
            $killLogs = $this->killLogService->getUnreadKillLogs(); //未読込ステータスのキルログを取得
            foreach ($killLogs as $log){
                $this->api->sendKillWebHook($log); //discordウェブフック送信(キル用)
                $this->killLogService->updateToReadedKillLog($log['id']); //キルログを読込済に更新
            }
            Log::info('api成功');
            return response()->json(['message' => '成功']);
        }catch (\Exception $exception){
            Log::error('api失敗');
            return response()->json(['message' => '失敗'], 500);
        }
    }
}
