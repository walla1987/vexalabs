<?php

namespace Tests\Feature;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateCampaignTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCampaignCanBeCreated(): void
    {
        $client = Client::factory()->create();
        $body = [
            'client_id' => $client->id,
            'name' => 'Campaign 1',
            'start_date' => Carbon::now()->toDateTimeString(),
            'end_date' => Carbon::now()->addDays(5)->toDateTimeString()
        ];

        $response = $this->postJson('api/campaigns', $body);
        $response->assertStatus(Response::HTTP_CREATED);

        //  assert record inserted
        $this->assertDatabaseHas('campaigns', $body);

        //  assert response body
        $response->assertJson(fn(AssertableJson $json) => $json->hasAll([
            'data',
            'data.id',
            'data.client_id',
            'data.start_date',
            'data.end_date',
            'data.created_at',
            'data.updated_at'
        ]));


    }
}
