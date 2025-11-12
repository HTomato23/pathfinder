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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->enum('status', ['Online', 'Offline', 'Disabled'])->default('Offline');
            $table->enum('role', ['Administrator', 'Consultant', 'Blog Moderator']);
            $table->string('theme_preference')->default('light');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Admin::class)->constrained('admins', 'admin_id')->onDelete('cascade');
            $table->string('action'); 
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('consultation', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Admin::class)->constrained('admins', 'admin_id')->onDelete('cascade');
            $table->string('title');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['Upcoming', 'Ongoing', 'Completed', 'Cancelled']);
            $table->timestamps();
        });

        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class)->constrained('users', 'id')->onDelete('cascade');
            $table->foreignIdFor(App\Models\Admin::class)->constrained('admins', 'admin_id')->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });

        Schema::create('jobs_portal', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('link');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
