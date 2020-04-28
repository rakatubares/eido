<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAwbValidationToImporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impor', function (Blueprint $table) {
            $table->boolean('awb_exist')->after('status_terakhir')->nullable()->index();
            $table->boolean('awb_consol')->after('awb_exist')->nullable()->index();
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
            $table->dropColumn(['awb_consol', 'awb_exist']);
        });
    }
}
