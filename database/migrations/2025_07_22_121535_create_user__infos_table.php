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
        Schema::create('user__infos', function (Blueprint $table) {
            $table->id();
            $table->integer('sl');
            $table->text('qr_url')->nullable();
            $table->integer('u_id')->nullable();
            $table->string('reg_no');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->boolean('duplicate')->default(0);
            $table->string('gender');
            $table->integer('age')->nullable();
            $table->date('dob')->nullable();
            $table->string('occupation')->nullable();
            $table->string('qt_status')->comment('graduate/pro-master');
            $table->boolean('quantum')->default(0);
            $table->boolean('quantier')->default(0);
            $table->boolean('ardentie')->default(0);
            $table->unsignedBigInteger('branch')->nullable();
            $table->boolean('job_status')->default(0);
            $table->boolean('psyche_certificate')->default(0);
            $table->string('sp')->default(0)->comment('Special Program');
            $table->string('group')->nullable();
            $table->string('call')->nullable();
            $table->boolean('sms')->default(0);
            $table->string('color')->nullable()->comment('red/green');
            $table->boolean('barcode')->default(0);
            $table->string('new_barcode')->nullable();
            $table->string('new_barcode_sl')->nullable();
            $table->boolean('barcode_delivery')->default(0);
            $table->date('first_attend')->nullable();
            $table->date('last_attend')->nullable();
            $table->string('status')->default(1);
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            // Foreignkey Decleration 
            $table->foreign('branch')->references('id')->on('branches')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user__infos');
    }
};
