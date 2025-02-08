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
        Schema::table('location_product', function (Blueprint $table) {
            $table->unsignedBigInteger('location_dusun_id')->nullable();
            $table->unsignedBigInteger('location_desa_id')->nullable();
            $table->unsignedBigInteger('location_kecamatan_id')->nullable();
            $table->unsignedBigInteger('location_kabupaten_id')->nullable();
            $table->unsignedBigInteger('location_provinsi_id')->nullable();

            $table->foreign('location_dusun_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('location_desa_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('location_kecamatan_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('location_kabupaten_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('location_provinsi_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_product', function (Blueprint $table) {
            $table->dropForeign(['location_dusun_id']);
            $table->dropColumn('location_dusun_id');
            $table->dropForeign(['location_desa_id']);
            $table->dropColumn('location_desa_id');
            $table->dropForeign(['location_kecamatan_id']);
            $table->dropColumn('location_kecamatan_id');
            $table->dropForeign(['location_kabupaten_id']);
            $table->dropColumn('location_kabupaten_id');
            $table->dropForeign(['location_provinsi_id']);
            $table->dropColumn('location_provinsi_id');
        });
    }
};
