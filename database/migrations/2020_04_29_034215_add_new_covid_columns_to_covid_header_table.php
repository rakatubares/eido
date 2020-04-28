<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewCovidColumnsToCovidHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('covid_bebas_header', function (Blueprint $table) {
            $table->string('coa', 64)->after('tgl_awb')->nullable()->index();
            $table->date('tgl_coa')->after('coa')->nullable()->index();
            $table->string('dipa', 64)->after('tgl_coa')->nullable()->index();
            $table->date('tgl_dipa')->after('dipa')->nullable()->index();
            $table->string('invoice', 64)->after('tgl_dipa')->nullable()->index();
            $table->date('tgl_invoice')->after('invoice')->nullable()->index();
            $table->string('packing_list', 64)->after('tgl_invoice')->nullable()->index();
            $table->date('tgl_packing_list')->after('packing_list')->nullable()->index();
            $table->string('pernyataan', 64)->after('tgl_packing_list')->nullable()->index();
            $table->date('tgl_pernyataan')->after('pernyataan')->nullable()->index();
            $table->string('srt_hibah', 64)->after('tgl_pernyataan')->nullable()->index();
            $table->date('tgl_srt_hibah')->after('srt_hibah')->nullable()->index();
            $table->string('kantor_pengawas', 8)->after('kantor_permohonan')->nullable()->index();
            $table->text('tujuan_distribusi')->after('sumber_barang')->nullable();
            $table->string('jenis_fasilitas', 64)->after('skema_pmk')->nullable()->index();
            $table->string('file_coa', 256)->after('file_awb')->nullable();
            $table->string('file_dipa', 256)->after('file_coa')->nullable();
            $table->string('file_akta_yayasan', 256)->after('file_hibah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('covid_bebas_header', function (Blueprint $table) {
            $table->dropColumn([
                'coa',
                'tgl_coa',
                'dipa',
                'tgl_dipa',
                'invoice',
                'tgl_invoice',
                'packing_list',
                'tgl_packing_list',
                'pernyataan',
                'tgl_pernyataan',
                'srt_hibah',
                'tgl_srt_hibah',
                'kantor_pengawas',
                'tujuan_distribusi',
                'jenis_fasilitas',
                'file_coa',
                'file_dipa',
                'file_akta_yayasan'
            ]);
        });
    }
}
