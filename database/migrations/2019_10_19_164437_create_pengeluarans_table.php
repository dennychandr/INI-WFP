<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nominal');
            $table->string('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->string('jenis_transaksi');
            $table->integer('kategori_id')->unsigned();
            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->integer('subkategori_id')->unsigned()->nullable();
            $table->foreign('subkategori_id')->references('id')->on('subkategoris');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
            $table->dropForeign(['subkategori_id']);
            $table->dropColumn('subkategori_id');
        });
        Schema::dropIfExists('transaksis');
    }
}
