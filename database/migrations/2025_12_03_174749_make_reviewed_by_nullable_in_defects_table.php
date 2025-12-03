<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Try to drop foreign key constraint if it exists
        try {
            DB::statement('ALTER TABLE defects DROP FOREIGN KEY defects_reviewed_by_foreign');
        } catch (\Exception $e) {
            // Foreign key doesn't exist or has different name, continue
        }
        
        try {
            DB::statement('ALTER TABLE defects DROP FOREIGN KEY defects_reviewed_by_foreign_1');
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }
        
        Schema::table('defects', function (Blueprint $table) {
            // Make the column nullable
            $table->unsignedBigInteger('reviewed_by')->nullable()->change();
        });
        
        // Re-add foreign key constraint if column exists and is a foreign key
        try {
            Schema::table('defects', function (Blueprint $table) {
                $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            });
        } catch (\Exception $e) {
            // Foreign key might already exist, continue
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE defects DROP FOREIGN KEY defects_reviewed_by_foreign');
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }
        
        Schema::table('defects', function (Blueprint $table) {
            // Make the column not nullable
            $table->unsignedBigInteger('reviewed_by')->nullable(false)->change();
        });
        
        try {
            Schema::table('defects', function (Blueprint $table) {
                $table->foreign('reviewed_by')->references('id')->on('users');
            });
        } catch (\Exception $e) {
            // Continue if foreign key already exists
        }
    }
};
