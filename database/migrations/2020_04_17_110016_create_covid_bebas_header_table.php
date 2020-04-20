<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidBebasHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_bebas_header', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idTanggap')->index()->unique();

            $table->string('awb', 64)->nullable()->index();
            $table->date('tgl_awb')->nullable()->index();
            $table->string('no_permohonan', 64)->nullable()->index();
            $table->date('tgl_permohonan')->nullable()->index();
            $table->string('kantor_permohonan', 8)->nullable()->index();

            $table->unsignedInteger('jenis_entitas')->nullable()->index();
            $table->string('npwp_entitas', 32)->nullable()->index();
            $table->string('nama_entitas', 64)->nullable()->index();
            $table->text('alamat_entitas')->nullable();

            $table->string('nama_importir', 64)->nullable()->index();
            $table->string('npwp_importir', 32)->nullable()->index();
            $table->text('alamat_importir')->nullable();

            $table->text('proyek_kegiatan')->nullable();
            $table->text('penggunaan_barang')->nullable();
            $table->text('sumber_barang')->nullable();

            $table->string('nama_pic', 256)->nullable();
            $table->string('telp_pic', 64)->nullable();
            $table->string('telp2_pic', 64)->nullable();
            $table->string('mail_pic', 256)->nullable();
            $table->string('nama_pemohon', 256)->nullable();
            $table->string('jabatan_pemohon', 256)->nullable();

            $table->string('kantor_pemasukan', 8)->nullable()->index();

            $table->string('dok_layanan', 8)->nullable()->index();
            $table->string('no_dokumen_layanan', 64)->nullable()->index();
            $table->date('tgl_dokumen_layanan')->nullable()->index();

            $table->string('nama_pengirim', 256)->nullable()->index();
            $table->string('nama_penerima', 256)->nullable()->index();

            $table->string('valuta', 8)->nullable()->index();
            $table->float('ndpbm')->nullable();

            $table->string('field_tpb', 32)->nullable()->index();
            $table->string('area_pemasukan_tpb', 32)->nullable()->index();
            $table->string('pelabuhan_masuk', 8)->nullable()->index();
            $table->string('negara_asal', 8)->nullable()->index();

            $table->string('mekanisme', 32)->nullable()->index();
            $table->string('tindak_lanjut', 32)->nullable()->index();
            $table->string('skema_pmk', 8)->nullable()->index();

            $table->unsignedBigInteger('bm_bebas')->nullable();
            $table->unsignedBigInteger('ppn_bebas')->nullable();
            $table->unsignedBigInteger('ppnbm_bebas')->nullable();
            $table->unsignedBigInteger('cukai_bebas')->nullable();
            $table->string('status_bebas', 4)->nullable()->index();

            $table->string('no_rekomendasi_bnpb', 64)->nullable()->index();
            $table->date('tgl_rekomendasi_bnpb')->nullable()->index();
            $table->string('no_skmk', 64)->nullable()->index();
            $table->date('tgl_skmk')->nullable()->index();
            $table->string('file_skmk', 256)->nullable();
            $table->string('penerbit_skmk', 256)->nullable()->index();

            $table->string('realisasi', 256)->nullable();

            $table->string('no_akta_yayasan', 64)->nullable();
            $table->date('tgl_akta_yayasan')->nullable();

            $table->string('file_awb', 256)->nullable();
            $table->string('file_invoice', 256)->nullable();
            $table->string('file_packing_list', 256)->nullable();
            $table->string('file_pernyataan', 256)->nullable();
            $table->string('file_hibah', 256)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('covid_bebas_header');
    }
}
