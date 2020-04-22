<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTanggapToImpor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impor', function (Blueprint $table) {
            $table->unsignedInteger('idTanggap')->after('id')->nullable()->index();
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
            $table->dropColumn(['idTanggap']);
        });
    }
}
