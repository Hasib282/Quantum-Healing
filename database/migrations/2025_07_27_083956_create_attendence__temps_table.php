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
        Schema::create('attendence__temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->date('date');
            $table->string('reg_no')->nullable();
            $table->string('qr_url');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            // Foreignkey Decleration 
            $table->foreign('event_id')->references('id')->on('events')
                    ->onUpdate('cascade');
            $table->foreign('reg_no')->references('reg_no')->on('user__infos')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendence__temps');
    }
};
