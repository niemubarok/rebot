<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp', function (Blueprint $table) {
            $table->id();
            $table->string('kontak')->nullable()->unique();
            $table->string('nik')->nullable();
            $table->string('rm')->nullable();
            $table->string('nama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('jk')->nullable();
            $table->string('alamat')->nullable();
            $table->string('poli')->nullable();
            $table->string('dokter')->nullable();
            $table->string('tgl_berobat')->nullable();
            $table->longText('pesan')->nullable();
            $table->string('questions')->nullable();
            $table->integer('message_time')->nullable();

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
        Schema::dropIfExists('whatsapp');
    }
}
