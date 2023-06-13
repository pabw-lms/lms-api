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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable();
            $table->string('cover');
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->string('pages');
            $table->longText('description');
            $table->year('pub_year');
            $table->integer('stock');
            $table->integer('current_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
