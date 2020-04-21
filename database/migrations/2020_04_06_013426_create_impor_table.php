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
            $table->date('tgl_awb')->nullable()->index();

            $table->string('importir', 64)->index();
            $table->string('npwp', 32)->nullable()->index();
            $table->unsignedBigInteger('status_importir')->index();

            $table->string('pic', 64)->nullable()->index();
            $table->string('hp_pic', 32)->nullable();
            $table->string('email_pic', 254)->nullable();
            $table->date('tgl_clearance')->nullable();
            $table->time('wkt_clearance')->nullable();

            $table->boolean('check_rekomendasi')->nullable()->index();
            $table->string('dok_rekomendasi', 64)->nullable()->index();
            $table->date('tgl_rekomendasi')->nullable();
            $table->boolean('bebas')->index()->default(0);
            $table->boolean('check_bebas')->nullable()->index();
            $table->string('dok_bebas', 64)->nullable()->index();
            $table->date('tgl_bebas')->nullable();

            $table->unsignedBigInteger('rekomendasi_clearance')->index();
            $table->unsignedSmallInteger('status_terakhir')->index();
            $table->unsignedBigInteger('officer_id')->index();

            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();
            $table->softDeletes('deleted_at', 0);

            $table->foreign('status_importir')->references('id')->on('dim_jenis_importir');
            $table->foreign('rekomendasi_clearance')->references('id')->on('dim_rekomendasi');
            $table->foreign('status_terakhir')->references('kd_status')->on('dim_status');
            $table->foreign('officer')->references('id')->on('users');
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
