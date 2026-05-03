<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ..._create_menus_table.php
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('ukuran')->nullable();    // Kolom baru
            $table->string('variant')->nullable();
            $table->string('category');
            $table->text('description');
            // Simpel: 1 foto menu (path di storage/app/public/menu_images)
            $table->string('image')->nullable();
            $table->integer('price');
            $table->timestamps();
            // TAMBAHAN: Slug hanya boleh sama jika umkm_id berbeda
            $table->unique(['umkm_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
