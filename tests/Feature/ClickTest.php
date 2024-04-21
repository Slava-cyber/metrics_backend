<?php

namespace Tests\Feature;

use App\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClickTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_click_store_422(): void
    {
        $response = $this->postJson('/api/click', [
            'domain' => 'google.com',
            'page_url' => "http://google.com/login",
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2015-03-25',
            'time_zone' => '-420'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'domain' => [
                        'The selected domain is invalid.'
                    ]
                ]
            ]);
    }

    public function test_click_store_success(): void
    {
        $domain = Domain::factory()->create([
            'name' => 'google.com'
        ]);

        $this->assertDatabaseCount('visitors', 0);
        $this->assertDatabaseCount('page_urls', 0);
        $this->assertDatabaseCount('clicks', 0);

        $response = $this->postJson('/api/click', [
            'domain' => 'google.com',
            'page_url' => "http://google.com/login",
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2015-03-25',
            'time_zone' => '-420'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('page_urls', 1);
        $this->assertDatabaseHas('page_urls', [
            'name' => "http://google.com/login",
            'domain_id' => $domain->id
        ]);

        $this->assertDatabaseCount('visitors', 1);

        $this->assertDatabaseCount('clicks', 1);
        $this->assertDatabaseHas('clicks', [
            'domain_id' => $domain->id,
            'time_zone' => '-420',
        ]);
    }

    public function test_click_store_domain_pause(): void
    {
        Domain::factory()->create([
            'name' => 'google.com',
            'pause' => 1
        ]);

        $this->assertDatabaseCount('visitors', 0);
        $this->assertDatabaseCount('page_urls', 0);
        $this->assertDatabaseCount('clicks', 0);

        $this->postJson('/api/click', [
            'domain' => 'google.com',
            'page_url' => "http://google.com/login",
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2015-03-25',
            'time_zone' => '-420'
        ]);

        $this->assertDatabaseCount('page_urls', 0);
        $this->assertDatabaseCount('visitors', 0);
        $this->assertDatabaseCount('clicks', 0);
    }

    public function test_click_store_validation_domain_fail(): void
    {
        $response = $this->postJson('/api/click', [
            'domain' => 'google.com',
            'page_url' => "http://google.com/login",
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2015-03-25',
            'time_zone' => '-420'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'domain' => [
                        'The selected domain is invalid.'
                    ]
                ]
            ]);
    }

    public function test_click_store_validation_date_fail(): void
    {
        $response = $this->postJson('/api/click', [
            'domain' => 'google.com',
            'page_url' => "http://google.com/login",
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => 43,
            'time_zone' => '-420'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'datetime' => [
                        'The datetime field must be a valid date.'
                    ]
                ]
            ]);
    }
}
