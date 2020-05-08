<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarkirLhpFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barkir_lhp_foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lhp_id')->index();
            $table->string('url', 256)->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unique(['lhp_id', 'url']);
            $table->foreign('lhp_id')->references('id')->on('barkir_lhp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barkir_lhp_foto');
    }
}
