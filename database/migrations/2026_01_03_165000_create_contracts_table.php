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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();
           
            $table->string('contract_number');
            $table->enum('type', ['permanent', 'temporary', 'probation'])->default('permanent');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('salary', 10, 2);
            $table->string('file_path');
            $table->enum('status', ['active', 'expired', 'terminated'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('contract_number');
            $table->index('status');
            $table->index(['employee_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
