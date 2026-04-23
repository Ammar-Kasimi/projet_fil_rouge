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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pic')->nullable();
            $table->foreignId('ingredient_category_id')->nullable()->constrained();

            $table->float('carbs_per_100')->default(0);
            $table->float('calories_per_100')->default(0);
            $table->float('protein_per_100')->default(0);
            $table->float('fat_per_100')->default(0);

            $table->float('ml_to_g')->nullable();
            $table->float('piece_to_g')->nullable();

            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
