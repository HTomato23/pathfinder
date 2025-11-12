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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Author::class)->constrained('authors', 'id')->onDelete('cascade');
            $table->string('title')->unique();
            $table->text('description');
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Draft');
            $table->string('image_path')->nullable();
            $table->string('header_1')->nullable();
            $table->string('header_2')->nullable();
            $table->string('header_3')->nullable();
            $table->string('header_4')->nullable();
            $table->string('header_5')->nullable();
            $table->string('header_6')->nullable();
            $table->mediumText('content_1')->nullable();
            $table->mediumText('content_2')->nullable();
            $table->mediumText('content_3')->nullable();
            $table->mediumText('content_4')->nullable();
            $table->mediumText('content_5')->nullable();
            $table->mediumText('content_6')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
