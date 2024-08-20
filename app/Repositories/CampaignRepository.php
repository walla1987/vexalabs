<?php

namespace App\Repositories;

use App\Models\Campaign;

class CampaignRepository
{

    public function __construct(private readonly Campaign $model)
    {
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

}
