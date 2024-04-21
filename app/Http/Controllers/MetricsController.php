<?php

namespace App\Http\Controllers;

use App\Enums\ClickDateFieldsEnum\ClickDateFieldsEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Metrics\MetricsBaseRequest;
use App\Models\Click;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetricsController extends Controller
{
    /**
     * @param MetricsBaseRequest $request
     * @param int $pageId
     * @return array
     */
    public function getHeatMapData(MetricsBaseRequest $request, int $pageId): array
    {
        $timeStart = $request->query('date_start');
        $timeFinish = $request->query('date_finish');
        $visitorId = $request->query('visitor_id');

        $clickHeatMapData = Click::query()
            ->selectRaw('count(*) as total, position_x, position_y')
            ->byOneVisitor($visitorId)
            ->where('page_url_id', $pageId)
            ->betweenDates($timeStart, $timeFinish)
            ->groupBy('position_x')
            ->groupBy('position_y')
            ->orderByDesc('total')
            ->get();

        return ResponseHelper::successBody($clickHeatMapData->toArray());
    }

    /**
     * @param MetricsBaseRequest $request
     * @param int $domainId
     * @return array
     */
    public function getHistogramAttendanceData(MetricsBaseRequest $request, int $domainId): array
    {
        $timeStart = $request->query('date_start');
        $timeFinish = $request->query('date_finish');
        $visitorId = $request->query('visitor_id');

        $clickData = Click::query()
            ->select(DB::raw('hour(datetime) as hours'), DB::raw('COUNT(id) as total'))
            ->byOneVisitor($visitorId)
            ->where('domain_id', $domainId)
            ->betweenDates($timeStart, $timeFinish, ClickDateFieldsEnum::DATETIME)
            ->groupBy(DB::raw('hours'))
            ->orderBy('hours')
            ->get();

        return ResponseHelper::successBody($clickData->toArray());
    }
}
