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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->date('date')->index();
            $table->foreignId('category_id')->constrained()->index();
            $table->string('image')->nullable();
            $table->string('document')->nullable();
            $table->foreignId('created_by')->index();
            $table->foreignId('updated_by')->nullable()->index();
            $table->enum('status', ['Published', 'Draft'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
