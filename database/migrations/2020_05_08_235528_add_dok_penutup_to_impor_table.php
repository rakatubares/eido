<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDokPenutupToImporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impor', function (Blueprint $table) {
            $table->string('jns_dok_penutup', 32)->after('officer_id')->nullable()->index();
            $table->unsignedInteger('id_dok_penutup')->after('jns_dok_penutup')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('impor', function (Blueprint $table) {
            $table->dropColumn(['jns_dok_penutup', 'id_dok_penutup']);
        });
    }
}
