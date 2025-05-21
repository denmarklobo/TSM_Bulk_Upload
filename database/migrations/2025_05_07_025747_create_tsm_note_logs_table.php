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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('file_name');
            $table->string('action');
            $table->string('status');
            $table->timestamps();
        });
    }   


    public function down(): void
    {
        Schema::dropIfExists('tsm_note_logs');
    }
};
