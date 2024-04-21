<?php

namespace App\Http\Controllers;

use App\DTO\ClickStoreDTO;
use App\Enums\LogChannelsEnum;
use App\Http\Requests\Click\ClickStoreRequest;
use App\Models\Domain;
use App\Services\ClickService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ClickController extends Controller
{
    /**
     * @param ClickStoreRequest $request
     * @param ClickService $clickService
     * @return void
     */
    public function store(ClickStoreRequest $request, ClickService $clickService): void
    {
        $domain = Domain::where('name', $request->input('domain'))->first();

        if ($domain->pause) {
            Log::channel(LogChannelsEnum::METRICS->value)
                ->error($domain->name . ' is paused. Click is not registered ' . Carbon::now());

            return;
        }

        Log::channel(LogChannelsEnum::METRICS->value)->info('timezone', [$request->input('timezone')]);
        try {
            $clickStoreDTO = new ClickStoreDTO(
                $domain,
                $request->input('page_url'),
                $request->input('position_x'),
                $request->input('position_y'),
                $request->input('screen_size_x'),
                $request->input('screen_size_y'),
                $request->input('datetime'),
                $request->input('time_zone'),
                $request->getClientIp()
            );

            $clickService->create($clickStoreDTO);
        } catch (\Throwable $e) {
            Log::channel(LogChannelsEnum::METRICS->value)->error('The error of creating click log ' . Carbon::now(), [$e]);
        }
    }
}
