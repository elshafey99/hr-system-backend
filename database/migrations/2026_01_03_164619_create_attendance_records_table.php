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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();
            $table->date('date');
            $table->datetime('check_in_time');
            $table->datetime('check_out_time');
            $table->decimal('check_in_lat', 10, 8);
            $table->decimal('check_in_lng', 11, 8);
            $table->decimal('check_out_lat', 10, 8);
            $table->decimal('check_out_lng', 11, 8);
            $table->integer('delay_minutes')->default(0);
            $table->enum('status', ['present', 'absent', 'late', 'early_leave'])->default('present');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
