<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_requires_authentication_to_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    #[Test]
    public function dashboard_displays_urls()
    {
        $user = User::factory()->create();
        Url::factory()->count(5)->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('URLs Encurtadas');
    }
}
