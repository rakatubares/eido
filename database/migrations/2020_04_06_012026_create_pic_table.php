<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pic', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 64)->index();
            $table->string('no_hp', 32)->nullable()->index();
            $table->string('email', 254)->nullable()->index();
            $table->timestamps();
            $table->unique(['nama', 'no_hp', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pic');
    }
}
