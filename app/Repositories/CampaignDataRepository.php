<?php

namespace App\Repositories;

use App\Models\CampaignData;

class CampaignDataRepository
{

    public function __construct(
        private CampaignData $campaignData
    )
    {
    }

    public function create(array $data)
    {
        return $this->campaignData->create($data);
    }

}
