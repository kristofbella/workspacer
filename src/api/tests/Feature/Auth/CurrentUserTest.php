<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

/**
 * @group Auth
 * @group CurrentUser
 */
class CurrentUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_authenticated_user_cannot_get_current_user(): void
    {
        // Act
        $response = $this->json(Request::METHOD_GET, route('auth.me'));

        // Assert
        $response->assertUnauthorized();
        $response->assertSee('Unauthenticated');
    }

    public function test_authenticated_user_can_get_current_user(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Act
        $response = $this->json(Request::METHOD_GET, route('auth.me'));

        // Assert
        $response->assertOk();
        $response->assertJson([
            'id' => $user->id,
            'type' => 'users',
            'attributes' => [
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at?->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
