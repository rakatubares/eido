<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidBebasBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_bebas_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idTanggap')->index();
            $table->unsignedInteger('seri_barang')->index();
            $table->text('uraian_barang')->nullable();
            $table->unsignedInteger('kategori_barang')->nullable()->index();
            $table->string('kategori_lain', 64)->nullable()->index();
            $table->float('jumlah_barang')->nullable();
            $table->float('berat')->nullable();
            $table->float('volume')->nullable();
            $table->double('nilai_perkiraan')->nullable();
            $table->timestamps();

            $table->unique(['idTanggap', 'seri_barang']);
            $table->foreign('idTanggap')->references('idTanggap')->on('covid_bebas_header');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('covid_bebas_barang');
    }
}
