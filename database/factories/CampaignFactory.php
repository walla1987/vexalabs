<?php

namespace Database\Factories;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'client_id' => Client::factory(),
            'start_date' => Carbon::now()->toDateTimeString(),
            'end_date' => Carbon::now()->addDays(5)->toDateTimeString(),
        ];
    }
}
