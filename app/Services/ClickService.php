<?php

namespace App\Services;

use App\DTO\ClickStoreDTO;
use App\Enums\LogChannelsEnum;
use App\Helpers\ResponseHelper;
use App\Models\Click;
use App\Models\PageUrl;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClickService
{
    public function create(ClickStoreDTO $clickData): Click
    {
        return DB::transaction(function () use ($clickData) {
            $pageUrlModel = PageUrl::firstOrCreate(
                ['name' => $clickData->pageUrl],
                ['domain_id' => $clickData->domain->id]
            );

            $visitor = Visitor::firstOrCreate(
                ['ip' => $clickData->ip]
            );

            return Click::create([
                'domain_id' => $clickData->domain->id,
                'page_url_id' => $pageUrlModel->id,
                'visitor_id' => $visitor->id,
                'datetime' => Carbon::parse($clickData->datetime),
                'position_x' => $clickData->positionX,
                'position_y' => $clickData->positionY,
                'screen_size_x' => $clickData->screenSizeX,
                'screen_size_y' => $clickData->screenSizeY,
                'time_zone' => $clickData->timeZone
            ]);
        });
    }

}
