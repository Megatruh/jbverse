<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ..._create_combination_details_table.php (Tabel Pivot)
    public function up(): void
    {
        Schema::create('combination_details', function (Blueprint $table) {
            $table->foreignId('combination_id')->constrained('menu_combinations')->cascadeOnDelete();
            $table->foreignId('variant_option_id')->constrained('variant_options')->cascadeOnDelete();
            $table->primary(['combination_id', 'variant_option_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combination_details');
    }
};
