<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Bus\PendingBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateCampaignDataTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCampaignDataCanBeCreated(): void
    {
        Bus::fake();
        $campaign = Campaign::factory()->create();
        $users = User::factory()->count(2)->create();
        $payload = [
            [
                'user_id' => $users->first()->id,
                'video_url' => $this->faker->url,
                'custom_fields' => ['hello' => 'world']
            ],
            [
                'user_id' => $users->last()->id,
                'video_url' => $this->faker->url
            ],
        ];

        $response = $this->postJson('api/campaigns/' . $campaign->id . '/data', ['user_data' => $payload]);
        $response->assertStatus(Response::HTTP_ACCEPTED);

        // assert job was fired off once
        Bus::assertBatched(function (PendingBatch $batch) use ($payload) {
           return $batch->jobs->count() === count($payload);
        });
    }
}
