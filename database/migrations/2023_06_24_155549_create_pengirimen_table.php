<?php

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Project;
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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('tgl_pengiriman')->nullable();
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Driver::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Project::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('jam')->nullable();
            $table->string('jml_product')->nullable();
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
        Schema::dropIfExists('pengiriman');
    }
};
