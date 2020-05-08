<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarkirPungutanPenetapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barkir_pungutan_penetapan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barkir_id')->index();
            $table->string('jns_pungutan', 16)->index();
            $table->unsignedBigInteger('nilai')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unique(['barkir_id', 'jns_pungutan']);
            $table->foreign('barkir_id')->references('id')->on('barkir_header');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barkir_pungutan_penetapan');
    }
}
