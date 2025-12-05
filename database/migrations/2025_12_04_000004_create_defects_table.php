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
        if (Schema::hasTable('defects')) {
            return;
        }

        Schema::create('defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->string('proof_image', 500)->nullable();
            $table->integer('quantity_affected')->default(0);
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'resolved'])->default('pending');
            $table->text('action_taken')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defects');
    }
};

