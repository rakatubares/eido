<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedByToImpor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impor', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_by')->after('updated_by')->nullable()->index();
            $table->foreign('deleted_by')->references('id')->on('users');
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
            $table->dropColumn(['deleted_by']);
        });
    }
}
