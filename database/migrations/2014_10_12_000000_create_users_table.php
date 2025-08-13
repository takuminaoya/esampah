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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telp');
            $table->string('alamat');
            $table->unsignedBigInteger('banjar_id');
            $table->string('nik')->unique();
            $table->string('usaha')->nullable();
            $table->string('password');
            $table->boolean('verified')->default(false);
            $table->dateTime('tgl_verified')->nullable();
            $table->date('tenggat_bayar')->nullable();
            $table->unsignedBigInteger('kode_distribusi_id');
            $table->integer('biaya')->nullable();
            $table->unsignedBigInteger('rekanan_id')->nullable();
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();

            //$table->foreign('banjar_id')->references('id')->on('banjars')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
