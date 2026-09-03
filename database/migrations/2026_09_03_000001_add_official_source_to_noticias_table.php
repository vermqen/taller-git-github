<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('noticias', 'fuente_nombre')) {
            Schema::table('noticias', function (Blueprint $table): void {
                $table->string('fuente_nombre', 120)->nullable()->after('categoria');
            });
        }

        if (! Schema::hasColumn('noticias', 'fuente_url')) {
            Schema::table('noticias', function (Blueprint $table): void {
                $table->string('fuente_url', 2048)->nullable()->after('imagen_url');
            });
        }

        if (! Schema::hasColumn('noticias', 'fuente_hash')) {
            Schema::table('noticias', function (Blueprint $table): void {
                $table->string('fuente_hash', 64)->nullable()->unique()->after('fuente_url');
            });
        }

        if (! Schema::hasColumn('noticias', 'es_oficial')) {
            Schema::table('noticias', function (Blueprint $table): void {
                $table->boolean('es_oficial')->default(false)->after('fuente_url');
            });
        }
    }

    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table): void {
            if (Schema::hasColumn('noticias', 'fuente_hash')) {
                $table->dropUnique(['fuente_hash']);
            }

            $columns = array_values(array_filter([
                Schema::hasColumn('noticias', 'fuente_nombre') ? 'fuente_nombre' : null,
                Schema::hasColumn('noticias', 'fuente_url') ? 'fuente_url' : null,
                Schema::hasColumn('noticias', 'fuente_hash') ? 'fuente_hash' : null,
                Schema::hasColumn('noticias', 'es_oficial') ? 'es_oficial' : null,
            ]));

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
