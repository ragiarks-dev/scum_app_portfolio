<?php

namespace App\Service;

use App\Models\KillLog;

class KillLogService
{
    public function getUnreadKillLogs(): array
    {
        return KillLog::where('status', '0')
            ->whereNotNull('killer_steam_id')
            ->whereNotNull('victim_steam_id')
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    public function updateToReadedKillLog(int $id): bool
    {
        $killLog = KillLog::find($id);

        if (!$killLog){
            return false;
        }

        $killLog->status = 1; //読込済みに更新

        if (!$killLog->save()){
            return false;
        }

        return true;
    }

    public function createKillLog($log): bool
    {
        $killLog = KillLog::create([
            'killer_name' => $log->Killer->ProfileName,
            'victim_name' => $log->Victim->ProfileName,
            'killer_steam_id' => $log->Killer->UserId,
            'victim_steam_id' => $log->Victim->UserId,
            'killer_latitude' => $log->Killer->ClientLocation->X,
            'killer_longitude' => $log->Killer->ClientLocation->Y,
            'victim_latitude' => $log->Victim->ClientLocation->X,
            'victim_longitude' => $log->Victim->ClientLocation->Y,
            'weapon' => $log->Weapon ?? 'Unknown',
        ]);

        if (!$killLog){
            return false;
        }

        return true;
    }

    public function firstKillLogChecker($log): bool
    {
        $killLog = KillLog::where('killer_steam_id', $log->Killer->UserId)
            ->where('status', '0')
            ->orderBy('id', 'desc')
            ->first();

        if (!$killLog){
            return true;
        }

        if (is_null($killLog->killer_name) && is_null($killLog->victim_name) && is_null($killLog->victim_steam_id)){
            return false;
        }elseif (!is_null($killLog->victim_steam_id)){
            return true;
        }

        //読み取れ漏れの恐れがあるため削除
        $killLog->delete();

        return true;
    }
}
