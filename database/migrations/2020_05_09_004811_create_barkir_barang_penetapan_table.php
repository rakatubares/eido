<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarkirBarangPenetapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barkir_barang_penetapan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('barkir_id')->index();
            $table->unsignedInteger('seri')->index();

            $table->string('hs', 16)->nullable()->index();
            $table->text('uraian')->nullable();
            $table->string('negara_asal', 4)->nullable()->index();

            $table->string('jns_bm', 4)->nullable()->index();
            $table->string('jns_bm_ur', 16)->nullable()->index();
            $table->unsignedInteger('jml_satuan_bm');
            $table->float('tarif_bm');
            $table->float('bm');

            $table->float('tarif_ppn');
            $table->float('ppn');
            $table->float('tarif_ppnbm');
            $table->float('ppnbm');
            $table->float('tarif_pph');
            $table->float('pph');

            $table->unsignedInteger('jml_kemasan');
            $table->string('jns_kemasan', 8)->nullable()->index();
            $table->float('jml_satuan');
            $table->string('jns_satuan', 8)->nullable()->index();

            $table->float('netto');
            $table->float('satuan_harga');
            $table->float('cif');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unique(['barkir_id', 'seri']);
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
        Schema::dropIfExists('barkir_barang_penetapan');
    }
}
