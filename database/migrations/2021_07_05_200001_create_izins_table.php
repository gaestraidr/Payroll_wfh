<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->string('photo');
            $table->string('tanggal_izin');
            $table->string('sampai_tanggal');
            $table->unsignedBigInteger('pegawai_id');
            $table->integer('approval')->default(0);
            $table->timestamps();
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ijins');
    }
}
