<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAwbDuplicateToImporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impor', function (Blueprint $table) {
            $table->unsignedInteger('awb_duplicate')->after('awb')->default(0)->index();
            $table->unique(['awb', 'awb_duplicate']);
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
            $table->dropUnique(['awb', 'awb_duplicate']);
            $table->dropColumn(['awb_duplicate']);
        });
    }
}
