<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarkirHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barkir_header', function (Blueprint $table) {
            $table->id();

            $table->string('no_barkir', 64)->nullable()->index();
            $table->string('jns_barkir', 16)->nullable()->index();
            $table->string('kd_pibk', 64)->nullable()->index();

            $table->string('nama_pengirim', 128)->nullable()->index();
            $table->text('alamat_pengirim')->nullable();
            $table->string('negara_pengirim', 64)->nullable()->index();

            $table->string('nama_penerima', 128)->nullable()->index();
            $table->text('alamat_penerima')->nullable();
            $table->string('id_penerima', 32)->nullable()->index();
            $table->string('telp_penerima', 32)->nullable()->index();

            $table->string('nama_pemberitahu', 128)->nullable()->index();
            $table->string('id_pemberitahu', 32)->nullable()->index();
            $table->string('no_ppjk', 64)->nullable()->index();

            $table->string('cara_angkut', 32)->nullable()->index();
            $table->string('nama_pengangkut', 128)->nullable()->index();
            $table->string('kode_angkut', 16)->nullable()->index();
            $table->string('pelb_muat', 64)->nullable()->index();
            $table->string('pelb_bongkar', 64)->nullable()->index();

            $table->string('invoice', 64)->nullable();
            $table->date('tgl_invoice')->nullable();
            $table->string('awb', 64)->nullable()->index();
            $table->date('tgl_awb')->nullable()->index();
            $table->unsignedInteger('bc_11')->nullable()->index();
            $table->date('tgl_bc_11')->nullable()->index();
            $table->unsignedInteger('pos')->nullable()->index();
            $table->unsignedInteger('subpos')->nullable()->index();
            $table->unsignedInteger('subsubpos')->nullable()->index();

            $table->unsignedInteger('jumlah_barang')->nullable();
            $table->string('valuta', 8)->nullable()->index();

            $table->float('ndpbm_aju')->nullable();
            $table->float('fob_aju')->nullable();
            $table->float('freight_aju')->nullable();
            $table->float('asuransi_aju')->nullable();
            $table->float('cif_aju')->nullable();
            $table->float('nilai_pabean_aju')->nullable();
            $table->float('total_pungutan_aju')->nullable();
            $table->float('total_dibayar_aju')->nullable();

            $table->float('ndpbm_penetapan')->nullable();
            $table->float('fob_penetapan')->nullable();
            $table->float('freight_penetapan')->nullable();
            $table->float('asuransi_penetapan')->nullable();
            $table->float('cif_penetapan')->nullable();
            $table->float('nilai_pabean_penetapan')->nullable();
            $table->float('total_pungutan_penetapan')->nullable();
            $table->float('total_dibayar_penetapan')->nullable();

            $table->float('bruto')->nullable();
            $table->float('netto')->nullable();

            $table->string('pdtt', 128)->nullable()->index();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->unique(['awb', 'tgl_awb']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barkir_header');
    }
}
