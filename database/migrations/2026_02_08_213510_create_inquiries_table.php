<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This executes when you run: php artisan migrate
     */
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            // Primary key - auto-incrementing ID
            $table->id();
            
            // User information
            $table->string('name');
            $table->string('email');
            
            // Inquiry details
            $table->enum('category', [
                'trading',
                'market_data', 
                'technical_issues',
                'general'
            ]);
            
            $table->string('subject');
            $table->text('message');
            
            // Timestamps - created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * This executes when you run: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};