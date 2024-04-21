<?php

namespace Tests\Feature;

use App\Models\Click;
use App\Models\Domain;
use App\Models\PageUrl;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetricsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_histogram(): void
    {
        $domain = Domain::factory()->create([
            'name' => 'google.com'
        ]);

        $page = PageUrl::factory()->create([
            'name' => 'http://google.com/login',
            'domain_id' => $domain->id
        ]);

        $visitor = Visitor::factory()->create([
            'ip' => '127.0.0.1'
        ]);

        Click::factory()->create([
            'domain_id' => $domain->id,
            'page_url_id' => $page->id,
            'visitor_id' => $visitor->id,
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2023-07-07 16:04:40',
            'time_zone' => '-420'
        ]);

        Click::factory()->create([
            'domain_id' => $domain->id,
            'page_url_id' => $page->id,
            'visitor_id' => $visitor->id,
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2023-07-07 16:05:40',
            'time_zone' => '-420'
        ]);

        Click::factory()->create([
            'domain_id' => $domain->id,
            'page_url_id' => $page->id,
            'visitor_id' => $visitor->id,
            'position_x' => 400,
            'position_y' => 500,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2023-07-07 15:04:40',
            'time_zone' => '-420'
        ]);

        $response = $this->get("/api/metrics/domain/{$domain->id}/histogram");

        $response->assertStatus(200);
        $response->assertJsonPath('data', [
            [
                'hours' => 15,
                'total' => 1,
            ],
            [
                'hours' => 16,
                'total' => 2
            ]
        ]);
    }

    public function test_heatmap(): void
    {
        $domain = Domain::factory()->create([
            'name' => 'google.com'
        ]);

        $page = PageUrl::factory()->create([
            'name' => 'http://google.com/login',
            'domain_id' => $domain->id
        ]);

        $visitor = Visitor::factory()->create([
            'ip' => '127.0.0.1'
        ]);

        Click::factory()->create([
            'domain_id' => $domain->id,
            'page_url_id' => $page->id,
            'visitor_id' => $visitor->id,
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2023-07-07 16:04:40',
            'time_zone' => '-420'
        ]);

        Click::factory()->create([
            'domain_id' => $domain->id,
            'page_url_id' => $page->id,
            'visitor_id' => $visitor->id,
            'position_x' => 400,
            'position_y' => 400,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2023-07-07 16:05:40',
            'time_zone' => '-420'
        ]);

        Click::factory()->create([
            'domain_id' => $domain->id,
            'page_url_id' => $page->id,
            'visitor_id' => $visitor->id,
            'position_x' => 400,
            'position_y' => 500,
            'screen_size_x' => 1000,
            'screen_size_y' => 1000,
            'datetime' => '2023-07-07 15:04:40',
            'time_zone' => '-420'
        ]);

        $response = $this->get("/api/metrics/page/{$page->id}/heatMap");

        $response->assertStatus(200);
        $response->assertJsonPath('data', [
            [
                'total' => 2,
                'position_x' => 400,
                'position_y' => 400,
            ],
            [
                'total' => 1,
                'position_x' => 400,
                'position_y' => 500,
            ]
        ]);
    }
}
