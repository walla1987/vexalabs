<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignData extends Model
{
    use HasFactory;

    protected $table = 'campaign_data';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'video_url',
        'custom_fields'
    ];
}
