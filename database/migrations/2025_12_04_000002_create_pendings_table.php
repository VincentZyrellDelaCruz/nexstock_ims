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
        if (Schema::hasTable('pendings')) {
            return;
        }

        Schema::create('pendings', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'defect' or 'restock'
            $table->unsignedBigInteger('reference_id'); // ID from defects or restock_confirmations table
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending'); // Changed from enum to string for compatibility
            $table->text('message')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            // Index for faster lookups
            $table->index(['type', 'reference_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendings');
    }
};

