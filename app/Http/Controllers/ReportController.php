<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Service\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class ReportController extends BaseController
{
    private ReportService $reportService;

    #[Pure] public function __construct(ReportService $reportService)
    {
        parent::__construct();
        $this->reportService = $reportService;
    }

    public function index(Request $request): JsonResponse
    {
        $reports = $this->reportService->getReports($request->get('search'));

        $this->response['result'] = [
            'reports' => $reports
        ];

        return response()->json($this->response);
    }

    public function sendReport(ReportRequest $request): JsonResponse
    {
        $status = $this->reportService->createReport($request);

        return response()->json($this->response, $status);
    }

    public function destroy(Request $request): JsonResponse
    {
        $status = $this->reportService->destroyReports($request->get('deletes'));

        return response()->json($this->response, $status);
    }
}
