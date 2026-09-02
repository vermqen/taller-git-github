<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_emisor', 'id_receptor', 'contenido', 'leido'])]
class MensajePrivado extends Model
{
    protected $table = 'mensajes_privados';

    protected $primaryKey = 'id_mensaje';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'contenido' => 'encrypted',
            'fecha_envio' => 'datetime',
            'leido' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function emisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_emisor');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function receptor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_receptor');
    }
}
