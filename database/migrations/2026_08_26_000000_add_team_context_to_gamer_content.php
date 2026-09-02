<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['publicaciones', 'comunidades', 'noticias', 'comentarios', 'problemas'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                if (! Schema::hasColumn($tableName, 'team_id')) {
                    $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
                }
            });
        }

        Schema::table('noticias', function (Blueprint $table): void {
            if (! Schema::hasColumn('noticias', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        // This migration conditionally adds columns that may predate it.
        // Keeping the rollback empty prevents deleting columns owned by another migration.
    }
};
