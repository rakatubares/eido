<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidBebasValidasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_bebas_validasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idTanggap')->index();
            $table->string('keterangan', 64)->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unique(['idTanggap', 'keterangan']);
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
        Schema::dropIfExists('covid_bebas_validasi');
    }
}
