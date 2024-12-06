<?php

namespace Tests\Feature;

use App\Mail\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * @covers \App\Http\Controllers\InvitationController
     *
     * @group invite
     * @group feature
     */
    // public function itShouldBeAbleToInviteSomeoneToThePlatform(): void
    public function it_should_be_able_to_invite_someone_to_the_platform(): void
    {
        // Arrange
        Mail::fake();

        // Preciso ter um usuario que va convidar
        /** @var User $user */
        $user = User::factory()->create();

        // Preciso esta logado
        $this->actingAs($user);

        // Act

        $this->post('invite', [
            'email' => 'qK6fI@example.com',
        ]);

        // Assert

        //  Email foi enviado
        Mail::assertSent(Invitation::class, function ($mail) {
            return $mail->hasTo('qK6fI@example.com');
        });

        // Criou um convite no banco de dados
        $this->assertDatabaseHas('invites', [
            'email' => 'qK6fI@example.com',
        ]);
    }
}
