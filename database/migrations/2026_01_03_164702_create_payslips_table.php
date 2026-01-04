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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();
            
            $table->tinyInteger('month')->comment('Month (1-12)');
            $table->year('year')->comment('Year');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('total_earnings', 10, 2);
            $table->decimal('total_deductions', 10, 2);
            $table->decimal('net_salary', 10, 2);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->datetime('published_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['employee_id', 'month', 'year']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
