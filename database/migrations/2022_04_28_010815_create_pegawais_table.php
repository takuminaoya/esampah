<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telp');
            $table->string('alamat');
            $table->unsignedBigInteger('banjar_id');
            $table->string('nik')->unique();
            $table->string('password');
            $table->string('level');
            $table->rememberToken();
            $table->timestamps();
            
            // $table->foreign('banjar_id')->references('id')->on('banjars')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('jalur_id')->references('id')->on('jalurs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
