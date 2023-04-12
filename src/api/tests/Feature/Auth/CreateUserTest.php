<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

/**
 * @group Auth
 * @group CreateUser
 */
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        // Arrange
        $user = User::factory()->make();

        // Act
        $response = $this->json(Request::METHOD_POST, route('auth.sign_up'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Assert
        $response->assertNoContent();
    }

    public function test_show_validation_error_when_all_fields_empty(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_up'), [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'name',
            'email',
            'password',
        ]);
    }

    public function test_show_validation_error_when_password_confirmation_missing(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_up'), [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'abcdabcd',
            'password_confirmation' => '',
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'password',
        ]);
    }

    public function test_show_validation_error_when_email_is_invalid(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_up'), [
            'name' => 'test',
            'email' => 'test',
            'password' => 'abcdabcd',
            'password_confirmation' => 'abcdabcd',
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email',
        ]);
    }

    public function test_show_validation_error_when_email_has_already_been_taken(): void
    {
        // Arrange
        $user = User::factory()->make();
        $this->json(Request::METHOD_POST, route('auth.sign_up'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Act
        $response = $this->json(Request::METHOD_POST, route('auth.sign_up'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email',
        ]);
    }
}
