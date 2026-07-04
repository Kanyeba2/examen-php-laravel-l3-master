<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_be_redirected_to_dashboard(): void
    {
        $response = $this->post('/register', [
            'nom' => 'Alice Test',
            'email' => 'alice@example.com',
            'telephone' => '0123456789',
            'adresse' => 'Lubumbashi',
            'mot_de_passe' => 'secret123',
            'mot_de_passe_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'alice@example.com']);
    }
}
