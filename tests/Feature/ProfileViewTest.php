<?php

namespace Tests\Feature;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_and_get_profile_views(): void
    {
        $profile = Profile::factory()->create();

        $this->getJson('/api/profiles/'.$profile->id, ['REMOTE_ADDR' => '1.1.1.1'])
            ->assertStatus(200)
            ->assertJson(['status' => true])
            ->assertJsonPath('data.views_count', 1);

        // same IP should not increase count
        $this->getJson('/api/profiles/'.$profile->id, ['REMOTE_ADDR' => '1.1.1.1'])
            ->assertStatus(200)
            ->assertJsonPath('data.views_count', 1);

        // different IP should increase count
        $this->getJson('/api/profiles/'.$profile->id, ['REMOTE_ADDR' => '2.2.2.2'])
            ->assertStatus(200)
            ->assertJsonPath('data.views_count', 2);

        $this->getJson('/api/profiles')
            ->assertStatus(200)
            ->assertJsonPath('data.data.0.views_count', 2);
    }
}
