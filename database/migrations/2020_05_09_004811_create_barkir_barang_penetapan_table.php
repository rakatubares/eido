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
            $table->unsignedInteger('jml_satuan_bm')->nullable();
            $table->unsignedDecimal('tarif_bm', 8, 2)->nullable();
            $table->unsignedDecimal('bm', 20, 2)->nullable();

            $table->unsignedDecimal('tarif_ppn', 8, 2)->nullable();
            $table->unsignedDecimal('ppn', 20, 2)->nullable();
            $table->unsignedDecimal('tarif_ppnbm', 8, 2)->nullable();
            $table->unsignedDecimal('ppnbm', 20, 2)->nullable();
            $table->unsignedDecimal('tarif_pph', 8, 2)->nullable();
            $table->unsignedDecimal('pph', 20, 2)->nullable();

            $table->unsignedInteger('jml_kemasan')->nullable();
            $table->string('jns_kemasan', 8)->nullable()->index();
            $table->unsignedDecimal('jml_satuan', 20, 2)->nullable();
            $table->string('jns_satuan', 8)->nullable()->index();

            $table->unsignedDecimal('netto', 20, 2)->nullable();
            $table->unsignedDecimal('satuan_harga', 20, 2)->nullable();
            $table->unsignedDecimal('cif', 20, 2)->nullable();

            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();

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
