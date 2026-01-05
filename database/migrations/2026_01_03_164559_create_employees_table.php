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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('pin');
            $table->string('profile_image')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('marital_status');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->nullOnDelete();
          
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
          
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->nullOnDelete();
          
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->nullOnDelete();
          
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('employees')->nullOnDelete();
          
            $table->unsignedBigInteger('work_location_id')->nullable();
            $table->foreign('work_location_id')->references('id')->on('work_locations')->nullOnDelete();
          
            $table->unsignedBigInteger('work_schedule_id')->nullable();
            $table->foreign('work_schedule_id')->references('id')->on('work_schedules')->nullOnDelete();
          
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->enum('status', ['active', 'inactive' ,'terminated'])->default('active');
            
            // Authentication fields
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->string('fcm_token')->nullable()->comment('Firebase Cloud Messaging token for push notifications');
            $table->enum('device_type', ['android', 'ios', 'web'])->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('employee_number');
            $table->index('email');
            $table->index('status');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

