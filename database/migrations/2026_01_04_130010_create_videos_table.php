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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('poster_image')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in seconds');
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedInteger('favorites_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_censored')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('channel_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_featured');
            $table->index('published_at');
            $table->index('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
