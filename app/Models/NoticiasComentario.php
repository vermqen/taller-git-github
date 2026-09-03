<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoticiasComentario extends Model
{
    protected $table = 'noticias_comentarios';

    protected $fillable = ['noticia_id', 'user_id', 'contenido'];

    /** @return BelongsTo<noticias, $this> */
    public function noticia(): BelongsTo
    {
        return $this->belongsTo(noticias::class, 'noticia_id');
    }

    /** @return BelongsTo<User, $this> */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
