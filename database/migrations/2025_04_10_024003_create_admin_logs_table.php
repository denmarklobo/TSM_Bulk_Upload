<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key referencing 'users' table
            $table->string('job_number')->nullable();  // Job number, can be null
            $table->string('submitted_by')->nullable();  // Submitted by, can be null
            $table->string('name'); 
            $table->string('email');
            $table->string('action');  // New field to store action taken (e.g., suspended)
            $table->string('file_path')->nullable();  // File path, can be null
            $table->timestamp('processed_at')->useCurrent();  // Timestamp for when the action was processed
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
};
