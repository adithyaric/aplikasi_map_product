<?php

use App\Models\BahanBaku;
use App\Models\Category;
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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(BahanBaku::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('tgl_dibuat')->nullable();
            $table->string('harga')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('pembelians');
    }
};
