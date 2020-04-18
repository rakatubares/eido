<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidBebasDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_bebas_dokumen', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idTanggap')->index();
            $table->unsignedInteger('seri_dokumen')->index();
            $table->string('no_dokumen', 64)->nullable()->index();
            $table->date('tgl_dokumen')->nullable()->index();
            $table->text('keterangan')->nullable();
            $table->string('link', 256)->nullable();
            $table->timestamps();

            $table->unique(['idTanggap', 'seri_dokumen']);
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
        Schema::dropIfExists('covid_bebas_dokumen');
    }
}
