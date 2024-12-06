<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $email_confirmation
 * @property string $password
 */
class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function itShouldBeAbleToRegisterAsAUser(): void
    {
        // Arrange

        // Act
        $return = $this->post(route('register'), [
            'name' => 'Mayara',
            'email' => 'test@exemplo.com',
            'email_confirmation' => 'test@exemplo.com',
            'password' => 'uma-senha',
        ]);

        // Assert
        $return->assertRedirect('dashboard');

        $this->assertDatabaseHas('users', [
            'name' => 'Mayara',
            'email' => 'test@exemplo.com',
        ]);

        /** @var User $user */
        $user = User::whereEmail('test@exemplo.com')->firstOrFail();

        $this->assertTrue(
            Hash::check('uma-senha', $user->password),
            'Checking if password was saved and it is encrypted.'
        );
    }
}