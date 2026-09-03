<?php

namespace App\Models;

use Database\Factories\NoticiasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class noticias extends Model
{
    /** @use HasFactory<NoticiasFactory> */
    use HasFactory;

    protected $fillable = ['team_id', 'user_id', 'titulo', 'contenido', 'categoria', 'imagen_url', 'fuente_nombre', 'fuente_url', 'fuente_hash', 'es_oficial'];

    protected function casts(): array
    {
        return ['es_oficial' => 'boolean'];
    }

    /**
     * @return BelongsTo<Team, $this>
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return HasMany<NoticiasComentario, $this> */
    public function comentarios(): HasMany
    {
        return $this->hasMany(NoticiasComentario::class, 'noticia_id');
    }
}
