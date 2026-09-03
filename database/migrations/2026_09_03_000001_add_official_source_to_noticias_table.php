<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('noticias', function (Blueprint $table): void {
            $table->string('fuente_nombre', 120)->nullable()->after('categoria');
            $table->string('fuente_url', 2048)->nullable()->unique()->after('imagen_url');
            $table->boolean('es_oficial')->default(false)->after('fuente_url');
        });
    }

    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table): void {
            $table->dropUnique(['fuente_url']);
            $table->dropColumn(['fuente_nombre', 'fuente_url', 'es_oficial']);
        });
    }
};
