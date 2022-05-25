<?php

namespace App\Console;

use App\Common\Api;
use App\Common\Methods;
use App\Common\ScumLog;
use App\Service\KillLogService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    private ScumLog $scumLog;
    private Api $api;
    private KillLogService $killLogService;

    public function __construct(Application $app, Dispatcher $events, ScumLog $scumLog, Api $api, KillLogService $killLogService)
    {
        parent::__construct($app, $events);
        $this->scumLog = $scumLog;
        $this->api = $api;
        $this->killLogService = $killLogService;
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $date = date('Ymd200000', strtotime('yesterday'));
            $this->scumLog->logFileModelUpdate('kill', $date);
        })->dailyAt('5:05'); //毎日(時間指定)

        $schedule->call(function () {
            $date = date('Ymd040000');
            $this->scumLog->logFileModelUpdate('kill', $date);
        })->dailyAt('13:05'); //毎日(時間指定)

        $schedule->call(function () {
            $date = date('Ymd120000');
            $this->scumLog->logFileModelUpdate('kill', $date);
        })->dailyAt('21:05'); //毎日(時間指定)

        $schedule->call(function () {
            $this->api->sendServerStatusWebHook(); //discordウェブフック送信（サーバー情報用）
        })->hourly(); //毎時間

        $schedule->call(function () {
            $this->scumLog->getKillLog(); //キルログファイルからログの取得
            $killLogs = $this->killLogService->getUnreadKillLogs(); //未読込ステータスのキルログを取得
            foreach ($killLogs as $log){
                $this->api->sendKillWebHook($log); //discordウェブフック送信(キル用)
                $this->killLogService->updateToReadedKillLog($log['id']); //キルログを読込済に更新
            }
        })->everyMinute(); //毎分
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
