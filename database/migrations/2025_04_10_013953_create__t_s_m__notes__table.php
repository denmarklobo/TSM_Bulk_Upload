<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSMNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsm_notes', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->text('notes');
            $table->string('user')->default('UNKNOWN_USER');
            $table->string('file_path');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('users')
                  ->references('tsm_employee_code')
                  ->on('users')
                  ->onDelete('set default') // or 'set null' if preferred
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
