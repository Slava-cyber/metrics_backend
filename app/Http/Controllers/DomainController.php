<?php

namespace App\Http\Controllers;

use App\Enums\LogChannelsEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\DomainRequest;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $domains = Domain::all();

        return ResponseHelper::successBody($domains->toArray());
    }

    /**
     * @param DomainRequest $request
     * @return array
     */
    public function store(DomainRequest $request): array
    {
        try {
            $newDomain = Domain::create(
                $request->validated()
            );
        } catch (\Throwable $e) {
            Log::channel(LogChannelsEnum::METRICS->value)->error('Creating domain error', [$e]);

            return ResponseHelper::failureBody('Creating domain error');
        }

        return ResponseHelper::successBody($newDomain->toArray());
    }


    /**
     * @param Domain $domain
     * @return array
     */
    public function show(Domain $domain): array
    {
        return ResponseHelper::successBody($domain->load('pages')->toArray());
    }

    public function update(DomainRequest $request)
    {
    }
}
