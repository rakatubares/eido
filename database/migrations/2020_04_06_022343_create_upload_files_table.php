<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('impor_id')->index();
            $table->string('filename', 64)->unique();
            $table->string('comment', 32);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
            $table->foreign('impor_id')->references('id')->on('impor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_files');
    }
}
