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

            $metaData = [];

            if (isset($userData['custom_fields'])) {
                if(is_string($userData['custom_fields'])) {
                    $metaData = json_decode($userData['custom_fields'], true);
                }
                else {
                    $metaData = $userData['custom_fields'];
                }
            }

            $jobs[] = new CaptureCamapignData(
                $userData['user_id'],
                $campaign->id,
                $userData['video_url'],
                $metaData
            );
        }
        Bus::batch($jobs)->allowFailures()->dispatch();
        return response()->json([], Response::HTTP_ACCEPTED);
    }
}
