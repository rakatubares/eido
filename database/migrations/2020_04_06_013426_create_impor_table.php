<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impor', function (Blueprint $table) {
            $table->id();

            $table->string('awb', 64)->index();
            $table->date('tgl_awb')->index();

            $table->string('importir', 64)->index();
            $table->string('npwp', 32)->nullable()->index();
            $table->boolean('check_nib')->index()->default(0);
            $table->string('dok_nib', 64)->nullable()->index();
            $table->unsignedBigInteger('status_importir')->index();

            $table->string('pengirim', 64)->nullable()->index();

            $table->string('pic', 64)->nullable()->index();
            $table->string('hp_pic', 32)->nullable();
            $table->string('email_pic', 254)->nullable();
            $table->dateTime('perkiraan_clearance')->nullable();

            $table->boolean('check_lartas')->nullable()->index();
            $table->string('dok_lartas', 64)->nullable()->index();

            $table->boolean('bebas')->index()->default(0);
            $table->boolean('rekomendasi_bebas')->nullable()->index();
            $table->string('dok_rekomendasi_bebas', 64)->nullable()->index();
            $table->boolean('check_bebas')->nullable()->index();
            $table->string('dok_bebas', 64)->nullable()->index();

            $table->unsignedBigInteger('rekomendasi_clearance')->index();
            $table->unsignedSmallInteger('status_terakhir')->index();

            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();

            $table->unique(['awb', 'tgl_awb']);
            $table->foreign('status_importir')->references('id')->on('dim_jenis_importir');
            $table->foreign('rekomendasi_clearance')->references('id')->on('dim_rekomendasi');
            $table->foreign('status_terakhir')->references('kd_status')->on('dim_status');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impor');
    }
}
