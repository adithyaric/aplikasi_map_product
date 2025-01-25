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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['provinsi', 'kabupaten', 'kecamatan', 'desa', 'dusun']);
            $table->unsignedBigInteger('parent_id')->nullable(); // To establish hierarchy
            $table->foreign('parent_id')->references('id')->on('locations')->onDelete('cascade');
            $table->json('coordinates')->nullable(); // Polygon coordinates
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
