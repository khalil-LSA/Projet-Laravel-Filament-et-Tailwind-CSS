<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'images')) {
            Schema::table('products', function (Blueprint $table) {
                // Use json for MySQL/PostgreSQL, maps to TEXT on SQLite
                $table->json('images')->nullable()->after('slug');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'images')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }
    }
};
