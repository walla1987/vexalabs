<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampaignDataRequest;
use App\Jobs\CaptureCamapignData;
use App\Models\Campaign;
use Illuminate\Support\Facades\Bus;
use Symfony\Component\HttpFoundation\Response;

class CampaignDataController extends Controller
{
    public function create(Campaign $campaign, CreateCampaignDataRequest $request)
    {
        $jobs = [];
        foreach ($request->get('user_data') as $userData) {
            $jobs[] = new CaptureCamapignData(
                $userData['user_id'],
                $campaign->id,
                $userData['video_url'],
                $userData['custom_fields'] ?? []
            );
        }
        Bus::batch($jobs)->allowFailures()->dispatch();
        return response()->json([], Response::HTTP_ACCEPTED);
    }
}
