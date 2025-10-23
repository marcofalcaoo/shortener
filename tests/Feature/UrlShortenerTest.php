<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_shortened_url()
    {
        $response = $this->postJson('/api/urls', [
            'original_url' => 'https://google.com',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'short_url',
                'original_url',
                'short_code',
            ]);

        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://google.com',
        ]);
    }

    #[Test]
    public function it_validates_url_format()
    {
        $response = $this->postJson('/api/urls', [
            'original_url' => 'not-a-valid-url',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['original_url']);
    }

    #[Test]
    public function it_requires_original_url()
    {
        $response = $this->postJson('/api/urls', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['original_url']);
    }

    #[Test]
    public function it_can_list_all_urls()
    {
        Url::factory()->count(3)->create();

        $response = $this->getJson('/api/urls');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'original_url',
                        'short_url',
                        'short_code',
                        'access_count',
                        'created_at',
                    ],
                ],
            ])
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_redirects_to_original_url()
    {
        $url = Url::factory()->create([
            'original_url' => 'https://example.com',
            'short_code' => 'abc123',
            'access_count' => 0,
        ]);

        $response = $this->get('/s/abc123');

        $response->assertRedirect('https://example.com');
        
        $this->assertEquals(1, $url->fresh()->access_count);
    }

    #[Test]
    public function it_returns_404_for_invalid_short_code()
    {
        $response = $this->get('/s/invalid');

        $response->assertStatus(404);
    }

    #[Test]
    public function it_increments_access_count_on_redirect()
    {
        $url = Url::factory()->create([
            'short_code' => 'test123',
            'access_count' => 0,
        ]);

        $this->get('/s/test123');
        $this->get('/s/test123');
        $this->get('/s/test123');

        $this->assertEquals(3, $url->fresh()->access_count);
    }

    #[Test]
    public function it_enforces_rate_limiting()
    {
        for ($i = 0; $i < 61; $i++) {
            $response = $this->postJson('/api/urls', [
                'original_url' => "https://example{$i}.com",
            ]);
        }

        $response->assertStatus(429);
    }
}
