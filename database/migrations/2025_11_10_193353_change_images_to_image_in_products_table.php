<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Supprimer la colonne images (JSON)
            $table->dropColumn('images');
            // Ajouter la nouvelle colonne image (string)
            $table->string('image')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Supprimer la colonne image
            $table->dropColumn('image');
            // Restaurer la colonne images (JSON)
            $table->json('images')->nullable()->after('slug');
        });
    }
};
