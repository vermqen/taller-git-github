<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('noticias', function (Blueprint $table): void {
            $table->index(['team_id', 'created_at'], 'noticias_team_created_at_index');
        });

        Schema::table('comentarios', function (Blueprint $table): void {
            $table->index(['team_id', 'fecha_comentario'], 'comentarios_team_fecha_index');
        });

        Schema::table('problemas', function (Blueprint $table): void {
            $table->index(['team_id', 'estado', 'created_at'], 'problemas_team_estado_created_at_index');
            $table->index(['team_id', 'prioridad', 'created_at'], 'problemas_team_prioridad_created_at_index');
        });

        Schema::table('votos_soporte', function (Blueprint $table): void {
            $table->index('id_usuario', 'votos_soporte_usuario_index');
        });
    }

    public function down(): void
    {
        Schema::table('votos_soporte', function (Blueprint $table): void {
            $table->dropIndex('votos_soporte_usuario_index');
        });

        Schema::table('problemas', function (Blueprint $table): void {
            $table->dropIndex('problemas_team_estado_created_at_index');
            $table->dropIndex('problemas_team_prioridad_created_at_index');
        });

        Schema::table('comentarios', function (Blueprint $table): void {
            $table->dropIndex('comentarios_team_fecha_index');
        });

        Schema::table('noticias', function (Blueprint $table): void {
            $table->dropIndex('noticias_team_created_at_index');
        });
    }
};
