<?php

namespace Tests\Unit;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UrlModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_generates_unique_short_codes()
    {
        $code1 = Url::generateShortCode();
        $code2 = Url::generateShortCode();

        $this->assertNotEquals($code1, $code2);
        $this->assertEquals(6, strlen($code1));
        $this->assertEquals(6, strlen($code2));
    }

    #[Test]
    public function it_returns_short_url_attribute()
    {
        $url = Url::factory()->create([
            'short_code' => 'abc123',
        ]);

        $this->assertStringContainsString('/s/abc123', $url->short_url);
    }

    #[Test]
    public function it_increments_access_count()
    {
        $url = Url::factory()->create(['access_count' => 5]);

        $url->incrementAccessCount();

        $this->assertEquals(6, $url->fresh()->access_count);
    }
}
