<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarkirLhpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barkir_lhp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barkir_id')->unique();
            $table->string('nama_pemeriksa', 128)->nullable()->index();
            $table->string('nip_pemeriksa', 32)->nullable()->index();
            $table->text('rekomendasi')->nullable();
            $table->text('uraian')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('barkir_lhp');
    }
}
