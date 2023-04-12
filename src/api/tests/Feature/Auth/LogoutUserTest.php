<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

/**
 * @group Auth
 * @group Logout
 */
class LogoutUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Act
        $response = $this->json(Request::METHOD_POST, route('auth.sign_out'));

        // Assert
        $response->assertNoContent();
    }

    public function test_non_authenticated_user_cannot_logout(): void
    {
        // Act
        $response = $this->json(Request::METHOD_POST, route('auth.sign_out'));

        // Assert
        $response->assertUnauthorized();
        $response->assertSee('Unauthenticated');
    }
}
