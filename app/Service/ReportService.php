<?php

namespace App\Service;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportService
{
    //todo:要テスト(検索機能)
    public function getReports($search): array
    {
        return DB::table('report')->select('report.id as report_id', 'type', 'detail', 'to_id', 'report.status as report_status',
            'users.user_name as from_name', 'USERS.user_name as to_name')
            ->leftJoin('users', function ($join){
                $join->on('users.id', 'from_id');
            })->leftJoinSub(DB::table('users')->toSql(), 'USERS', function ($join){
                $join->on('USERS.id', 'to_id');
            })->where('report.status', '!=', -1)
            ->where('users.user_name', 'like', '%' . $search . '%')
            ->where('USERS.user_name', 'like', '%' . $search . '%')
            ->where('detail', 'like', '%' . $search . '%')
            ->get()
            ->toArray();
    }

    public function createReport(ReportRequest $request): int
    {
        $report = (new Report())->fill($request->only('type', 'detail', 'to_id'));
        $report->from_id = Auth::id();

        if (!$report->save()){
            return 500;
        }

        return 200;
    }

    public function destroyReports(array $data): int
    {
        $destroyReports = Report::whereIn('id', $data)->update(['status' => -1]);

        if (!$destroyReports){
            return 500;
        }

        return 200;
    }
}
