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
        Schema::create('pendapatans', function (Blueprint $table) {
            $table->id();
            $table->string('bulan_bayar');
            $table->string('keterangan');
            $table->boolean('isTransfer');
            $table->integer('jumlah');
            $table->unsignedBigInteger('jenis_pendapatan_id')->nullable();
            $table->unsignedBigInteger('pembayaran_id')->nullable();
            $table->timestamps();

            $table->foreign('pembayaran_id')->references('id')->on('pembayarans')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('jenis_pendapatan_id')->references('id')->on('jenis_pendapatans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendapatans');
    }
};
