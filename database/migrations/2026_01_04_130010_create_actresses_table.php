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
        Schema::create('actresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('nationality')->nullable();
            $table->integer('height')->nullable()->comment('Height in cm');
            $table->string('measurements')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedInteger('videos_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_featured');
            $table->index('nationality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actresses');
    }
};
