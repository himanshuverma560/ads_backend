<?php

namespace Tests\Feature;

use App\Models\PageScript;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageScriptTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_page_script(): void
    {
        $payload = [
            'page_type' => 'home',
            'script' => 'console.log("a");',
            'position' => 1,
        ];

        $this->postJson('/api/page-scripts', $payload)
            ->assertStatus(201)
            ->assertJson(['status' => true])
            ->assertJsonPath('data.page_type', 'home');
    }


    public function test_duplicate_position_not_allowed(): void
    {
        PageScript::factory()->create(['page_type' => 'home', 'position' => 1]);

        $payload = [
            'page_type' => 'home',
            'script' => 'x',
            'position' => 1,
        ];

        $this->postJson('/api/page-scripts', $payload)
            ->assertStatus(422)
            ->assertJson(['status' => false]);
    }

    public function test_filter_by_page_type(): void
    {
        PageScript::factory()->create(['page_type' => 'home']);
        PageScript::factory()->create(['page_type' => 'other']);

        $this->getJson('/api/page-scripts?page_type=home')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_update_page_script(): void
    {
        $pageScript = PageScript::factory()->create([
            'page_type' => 'home',
            'script' => 'console.log("x");',
            'position' => 1,
        ]);

        $payload = [
            'page_type' => 'home',
            'script' => 'console.log("updated");',
            'position' => 1,
        ];

        $this->postJson('/api/page-scripts/' . $pageScript->id, $payload)
            ->assertStatus(200)
            ->assertJson(['status' => true])
            ->assertJsonPath('data.script', 'console.log("updated");');
    }
}
