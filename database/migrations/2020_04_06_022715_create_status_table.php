<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('impor_id')->index();
            $table->unsignedSmallInteger('kd_status')->index();
            $table->string('jns_dok_impor', 32)->nullable()->index();
            $table->string('no_dok_impor', 32)->nullable()->index();
            $table->string('detail', 64)->nullable()->index();
            $table->timestamps();
            $table->foreign('impor_id')->references('id')->on('impor');
            $table->foreign('kd_status')->references('kd_status')->on('dim_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
