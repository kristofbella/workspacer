<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group Auth
 * @group LoginUser
 */
class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_access_token_and_access_token_after_successful_login(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->json('POST', route('auth.sign_in'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
    }

    public function test_show_validation_error_when_both_fields_empty(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_in'), [
            'email' => '',
            'password' => ''
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_show_validation_error_on_email_when_credential_donot_match(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_in'), [
            'email' => 'test@test.com',
            'password' => 'abcdabcd'
        ]);

        // Assert
        $response->assertBadRequest();
        $response->assertJson(['message' => 'Invalid login credentials']);
    }

    public function test_show_validation_error_when_email_field_empty(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_in'), [
            'email' => '',
            'password' => 'abcdabcd'
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_show_validation_error_when_password_field_empty(): void
    {
        // Act
        $response = $this->json('POST', route('auth.sign_in'), [
            'email' => 'test@test.com',
            'password' => ''
        ]);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['password']);
    }
}
