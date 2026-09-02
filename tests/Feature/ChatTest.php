<?php

namespace Tests\Feature;

use App\Models\MensajePrivado;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_private_messages_are_encrypted_at_rest(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $message = 'Mensaje privado que no debe quedar en texto plano';

        $this->actingAs($sender)
            ->post(route('chat.store', $recipient), ['contenido' => $message])
            ->assertRedirect(route('chat.show', $recipient));

        $storedContent = DB::table('mensajes_privados')->value('contenido');

        $this->assertNotSame($message, $storedContent);
        $this->assertSame($message, MensajePrivado::query()->firstOrFail()->contenido);
    }

    public function test_chat_only_returns_messages_between_authenticated_user_and_recipient(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $outsider = User::factory()->create();

        MensajePrivado::query()->create([
            'id_emisor' => $sender->id,
            'id_receptor' => $recipient->id,
            'contenido' => 'Visible para el receptor',
            'leido' => false,
        ]);

        MensajePrivado::query()->create([
            'id_emisor' => $outsider->id,
            'id_receptor' => $recipient->id,
            'contenido' => 'No pertenece a esta conversación',
            'leido' => false,
        ]);

        $this->actingAs($sender)
            ->get(route('chat.show', $recipient))
            ->assertOk()
            ->assertSee('Visible para el receptor')
            ->assertDontSee('No pertenece a esta conversación');
    }
}
