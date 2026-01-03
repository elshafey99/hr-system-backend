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
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();

            $table->unsignedBigInteger('issued_by');
            $table->foreign('issued_by')->references('id')->on('admins')->nullOnDelete();

            $table->enum('type', ['verbal', 'written', 'final'])->default('verbal');
            $table->text('reason')->nullable();
            $table->datetime('issued_at')->nullable();
            $table->enum('status', ['active', 'objected', 'resolved'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warnings');
    }
};
