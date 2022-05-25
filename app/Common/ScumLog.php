<?php

namespace App\Common;

use App\Service\KillLogService;
use App\Service\UserService;
use App\Service\ScumLogService;
use App\Service\ProvisionalUserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\Pure;
use Exception;

class ScumLog
{
    private UserService $userService;
    private ScumLogService $scumLogService;
    private ProvisionalUserService $provisionalUserService;
    private KillLogService $killLogService;

    #[Pure] public function __construct(UserService $userService, ScumLogService $scumLogService, ProvisionalUserService $provisionalUserService, KillLogService $killLogService)
    {
        $this->userService = $userService;
        $this->scumLogService = $scumLogService;
        $this->provisionalUserService = $provisionalUserService;
        $this->killLogService = $killLogService;
    }

    //ログファイルモデル保存
    public function logFileModelUpdate($type, $date): void
    {
        $targetDate = $date;
        $seconds  = 0;
        while (!Storage::disk('ftp')->exists($type . '_' . $targetDate . '.log')){
            if ($seconds >= 1800){
                throw new Exception($type . 'のログファイルモデルの作成が失敗しました。（ログファイルが見つからない）');
            }
            $targetDate = date('YmdHis', strtotime($date . ' ' . $seconds . ' second'));
            $seconds++;
        }

        $fileName = $type . '_' . $targetDate . '.log';

        $status = $this->scumLogService->createLogFileModel($fileName, $type, $targetDate);

        if ($status == 500){
            Log::warning('logFileModelUpdate(' . $type . '): ログファイルモデルの保存が失敗しました。');
        }
    }

    public function getChatLog(): bool
    {
        try {
            $type = 'chat';
            $logFileModel = $this->scumLogService->getNewestLogFile($type);

            if (!$logFileModel){
                throw new Exception($type . 'のログファイルモデルが見つかりませんでした。');
            }

            $logFile = $this->getFile($logFileModel->file_name);

            if (!$logFile){
                throw new Exception($type . 'のログファイルが見つかりませんでした。');
            }

            $logsChangeToUtf8 =  $this->changeToUtf8($logFile);
            $logs = $this->changeToArray($logsChangeToUtf8);
            $count = $logFileModel->last_row;

            //ログが存在しない場合
            if (count($logs) < 2){
                return true;
            }

            $res = [];
            for ($cnt=$count+1; $cnt <= count($logs); $cnt++){

                if ($cnt < 2){
                    continue;
                }

                //最終読み込み行の更新
                if ($cnt == count($logs)){
                    $logFileModel->last_row = $cnt;
                    $logFileModel->save();
                    break;
                }

                //シングルクォーテーションで囲まれた文字列で分割
                $log = preg_split("/\x20(?=[^']*('[^']*'[^']*)*$)/", $logs[$cnt]);

                //行を整形
                $userInfo = str_replace("'", "", $log[1]);
                $chatInfo = str_replace("'", "", $log[2]);

                $steam64Id = $this->getSteam64Id($userInfo);
                $userName = $this->getUserName($userInfo);
                $chat = $this->getChat($chatInfo);

                $executionChatDetail = $this->executionChatDetail($steam64Id, $userName, $chat);

                if ($executionChatDetail){
                    Log::debug('getChatの実行: 成功');
                }
            }
            return true;
        }catch (Exception $ex){
            Log::error($ex);
            return false;
        }
    }

    public function getKillLog()
    {
        try {
            $type = 'kill';
            $logFileModel = $this->scumLogService->getNewestLogFile($type);

            if (!$logFileModel){
                throw new Exception($type . 'のログファイルモデルが見つかりませんでした。');
            }

            $logFile = $this->getFile($logFileModel->file_name);

            if (!$logFile){
                throw new Exception($type . 'のログファイルが見つかりませんでした。');
            }

            $logsChangeToUtf8 =  $this->changeToUtf8($logFile);
            $logs = $this->changeToArray($logsChangeToUtf8);
            $count = $logFileModel->last_row;

            //ログが存在しない場合
            if (count($logs) < 2){
                return true;
            }

            for ($cnt=$count+1; $cnt <= count($logs); $cnt++){

                if ($cnt < 2){
                    continue;
                }

                //最終読み込み行の更新
                if ($cnt == count($logs)){
                    $logFileModel->last_row = $cnt;
                    $logFileModel->save();
                    break;
                }

                //json形式変換
                $log = $this->getKillLogJson($logs[$cnt]);

                //連想配列にデコード
                $killLog = json_decode($log);

                //json形式ではなかった場合(ロケーションのみをセット)
                if (!$killLog){
                    continue;
                }

                if (!$this->killLogService->createKillLog($killLog)){
                    Log::error('getKillLogの実行: 失敗（createKillLog）');
                }
            }
            Log::debug('getKillLogの実行: 成功');
            return true;
        }catch (Exception $ex){
            Log::error($ex);
            return $ex->getMessage();
        }
    }

    //FTPでファイルを取得
    private function getFile($fileName): ?string
    {
        return Storage::disk('ftp')->get($fileName);
    }

    //UTF-8に変換
    private function changeToUtf8($storageLogFile): array|bool|string|null
    {
        return str_replace(array("\r\n", "\r", "\n"), "\n", mb_convert_encoding($storageLogFile, "UTF-8", "UTF-16LE"));
    }

    //配列化
    private function changeToArray($data): array
    {
        return explode("\n", $data);
    }

    //steam64IDの取得
    private function getSteam64Id($row): string
    {
        return strstr($row, ':', true);
    }

    //ゲーム内ユーザー名の取得
    private function getUserName($row): string
    {
        return str_replace(':', '', strchr(strstr($row, ':'), '(', true));
    }

    //チャット内容の取得
    private function getChat($row): string
    {
        return str_replace(':', '', strstr($row, ':'));
    }

    //キルログをjson形式に変換
    private function getKillLogJson($row)
    {
        return strstr($row, '{', false);
    }

    //キルログをjson形式に変換
    private function removeBefore($row, $needle)
    {
        return strstr($row, $needle, true);
    }

    //チャット内容によるDB登録(createaccount, etc...)
    private function executionChatDetail($steam64Id, $userName, $chat): Exception|bool
    {
        try {
            $type = strstr($chat, '!', true);
            $data = str_replace(' ', '', $chat);

            switch ($type){
                case 'createaccount':

                    //既に登録済のユーザーか検索
                    $user = $this->userService->searchWithLogin_Id($steam64Id);

                    if ($user){
                        break;
                    }

                    //仮登録ユーザーテーブルで検索
                    $provisionalUser = $this->provisionalUserService->search($data);

                    if (!$provisionalUser){

                        $fillData = [
                            'user_name' => $userName,
                            'steam_id' => $steam64Id,
                            'login_id' => $provisionalUser->login_id,
                            'password' => $provisionalUser->password,
                        ];

                        $status = $this->userService->createUser($fillData);

                        if ($status == 500){
                            throw new Exception('ユーザーの作成に失敗しました。(executionChatDetail)');
                        }

                        //仮登録ユーザーの
                        $provisionalUser->status = -2;
                        $provisionalUser->save();
                    }
                    break;

                default:
                    break;
            }

            return true;
        }catch (Exception $ex){
            return $ex;
        }
    }
}
