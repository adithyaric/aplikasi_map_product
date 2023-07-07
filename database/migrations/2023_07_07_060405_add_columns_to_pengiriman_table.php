<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengiriman', function (Blueprint $table) {
            $table->string('untuk_pengecoran')->nullable();
            $table->string('lokasi_pengecoran')->nullable();
            $table->string('dry_automatic')->nullable();
            $table->string('slump_permintaan')->nullable();
            $table->string('waktu_tempuh')->nullable();
            $table->string('rit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengiriman', function (Blueprint $table) {
            //
        });
    }
};
