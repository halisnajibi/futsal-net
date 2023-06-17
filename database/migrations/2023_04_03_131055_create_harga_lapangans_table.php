<?php

use App\Models\Hari;
use App\Models\Jam;
use App\Models\Lapangan;
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
        Schema::create('harga_lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->foreignIdFor(Lapangan::class);
            $table->string('hari');
            $table->foreignIdFor(Jam::class);
            $table->string('harga');
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
        Schema::dropIfExists('harga_lapangans');
    }
};
