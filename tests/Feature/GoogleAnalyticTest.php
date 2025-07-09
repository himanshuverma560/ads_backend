<?php

namespace Tests\Feature;

use App\Models\GoogleAnalytic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAnalyticTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_google_analytic_code(): void
    {
        $payload = ['code' => '<script>ga</script>'];

        $this->postJson('/api/google-analytics', $payload)
            ->assertStatus(201)
            ->assertJson(['status' => true])
            ->assertJsonPath('data.code', '<script>ga</script>');
    }

    public function test_get_google_analytic_code(): void
    {
        GoogleAnalytic::factory()->create(['code' => 'x']);

        $this->getJson('/api/google-analytics')
            ->assertStatus(200)
            ->assertJsonPath('data.code', 'x');
    }
}

