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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2); // Model ke 'price' se match karega
            $table->string('image')->nullable(); // Real images lagane ke liye URL store karega
            $table->text('description')->nullable(); 
            $table->integer('stock')->default(0);
            $table->integer('views_today')->default(0);
            $table->boolean('is_elastic')->default(true); // true = Elastic, false = Inelastic
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};