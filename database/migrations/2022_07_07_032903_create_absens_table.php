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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->boolean('valid')->default(0);
            $table->string('nip');
            $table->datetime('absen_time')->nullable();
            $table->boolean('absen_jenis')->default(0);
            $table->string('absen_longitude');
            $table->string('absen_latitude');
            $table->string('pangkat');
            $table->string('jabatan');
            $table->string('jarak');
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('absens');
    }
};
