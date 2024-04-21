<?php

namespace Tests\Feature;

use App\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_domain_index(): void
    {
        $response = $this->getJson('/api/domain/');
        $response->assertJsonPath('data', []);

        $domain = Domain::factory()->create([
           'name' => 'google.com',
           'pause' => 0
        ]);

        $response = $this->getJson('/api/domain/');

        $response->assertJsonPath('data.0.name', $domain->name);
        $response->assertStatus(200);
    }

    public function test_domain_store(): void
    {
        $response = $this->postJson('/api/domain/', [
            'name' => 'yandex.ru'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.name', 'yandex.ru');
        $this->assertDatabaseCount('domains', 1);
        $this->assertDatabaseHas('domains', [
            'name' => 'yandex.ru',
            'pause' => 0
        ]);

        $response = $this->postJson('/api/domain/', [
            'name' => 'yandex.ru'
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('/api/domain/', [
            'name' => 'yandexNew.ru',
            'pause' => 1
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('domains', 2);
        $this->assertDatabaseHas('domains', [
            'name' => 'yandexNew.ru',
            'pause' => 1
        ]);
    }
}
