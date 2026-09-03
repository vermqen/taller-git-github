<?php

namespace Tests\Feature;

use App\Models\noticias;
use App\Models\NoticiasComentario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_a_successful_response(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
    }

    public function test_public_home_shows_official_news_and_accepts_comments(): void
    {
        $news = noticias::create([
            'titulo' => 'Novedad oficial pública',
            'contenido' => 'Contenido oficial para toda la comunidad.',
            'fuente_nombre' => 'Xbox Wire',
            'fuente_url' => 'https://example.com/noticia-oficial',
            'es_oficial' => true,
        ]);
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Novedad oficial pública');

        $this->actingAs($user)
            ->post(route('official-news.comments.store', $news), ['contenido' => 'Excelente actualización.'])
            ->assertRedirect();

        $this->assertDatabaseHas('noticias_comentarios', [
            'noticia_id' => $news->id,
            'user_id' => $user->id,
            'contenido' => 'Excelente actualización.',
        ]);
        $this->assertInstanceOf(NoticiasComentario::class, NoticiasComentario::query()->first());
    }
}
