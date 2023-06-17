<?php

use App\Models\Jam;
use App\Models\Lapangan;
use App\Models\User;
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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('kode_pemesanan');
            $table->date('tanggal_mesan');
            $table->date('tanggal_main');
            $table->foreignIdFor(Lapangan::class);
            $table->foreignIdFor(Jam::class);
            $table->string('status');
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
        Schema::dropIfExists('pesanans');
    }
};
