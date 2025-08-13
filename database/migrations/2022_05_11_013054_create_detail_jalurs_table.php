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
        Schema::create('detail_jalurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jalur_id');
            $table->unsignedBigInteger('banjar_id')->unique();
            $table->timestamps();

            $table->foreign('jalur_id')->references('id')->on('jalurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('banjar_id')->references('id')->on('banjars')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_jalurs');
    }
};
