<?php

namespace App\Jobs;

use App\Repositories\CampaignDataRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CaptureCamapignData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public int $campaignId,
        public string $videoUrl,
        public array $metaData = []
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(CampaignDataRepository $campaignDataRepository): void
    {
        $campaignDataRepository->create([
            'campaign_id' => $this->campaignId,
            'user_id' => $this->userId,
            'video_url' => $this->videoUrl,
            'custom_fields' => $this->metaData ? json_encode($this->metaData) : null
        ]);
    }
}
