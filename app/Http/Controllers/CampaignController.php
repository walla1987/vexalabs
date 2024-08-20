<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignCreateRequest;
use App\Http\Resources\CampaignResource;
use App\Repositories\CampaignRepository;
use Symfony\Component\HttpFoundation\Response;

class CampaignController extends Controller
{
    public function __construct(
        private readonly CampaignRepository $campaignRepository
    ) {
    }

    public function create(CampaignCreateRequest $request)
    {
        $campaign = $this->campaignRepository->create($request->all());
        return (new CampaignResource($campaign))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
