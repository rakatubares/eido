<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_log', function (Blueprint $table) {
            $table->id();
            $table->string('hash', 32)->index();
            $table->string('app', 32)->index();
            $table->string('activity', 32)->index();
            $table->string('status', 64)->index();
            $table->string('detail', 256)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('covid_log');
    }
}
