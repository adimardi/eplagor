<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReffsatkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reffsatker');

        Schema::create('reffsatker', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('kode_satker', 6)->default('');
            $table->string('kode_eselon', 2)->default('');
            $table->enum('nama_eselon', ['Badan Urusan Administrasi', 'Kepaniteraan', 'Badan Peradilan Umum', 'Badan Peradilan Agama', 'Badan Litbang Diklat Kumdil', 'Badan Pengawasan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara']);
            $table->string('kode_wilayah', 4)->default('');
            $table->enum('kode_kantor', ['KP', 'KD']);
            $table->string('kode_satker_lengkap', 20)->nullable()->default('');
            $table->enum('status', ['TINGKAT PERTAMA', 'TINGKAT BANDING', 'SATKER PUSAT'])->nullable()->default('SATKER PUSAT');
            $table->string('nama_satker')->default('');
            $table->string('nama_satker_lengkap')->default('');
            $table->string('kota_satker')->nullable()->default('');
            $table->string('tingkat_banding')->nullable()->default('');
            $table->string('kota_tingkat_banding')->nullable()->default('');
            $table->string('korwil')->nullable();
            $table->string('dirjen')->nullable()->default('');
            $table->string('provinsi')->nullable();
            $table->string('kpknl')->nullable();
            $table->string('kanwil_djkn')->nullable()->default('');
            $table->timestamps();
            $table->string('ketua')->nullable();
            $table->string('ketua_nip', 18)->nullable()->default('');
            $table->string('bendahara')->nullable();
            $table->string('bendahara_nip', 18)->nullable()->default('');
            $table->string('sekretaris')->nullable();
            $table->string('sekretaris_nip', 18)->nullable()->default('');
            $table->string('panitera')->nullable();
            $table->string('panitera_nip', 18)->nullable();
            $table->string('kasir')->nullable();
            $table->string('kasir_nip', 18)->nullable();
            $table->enum('peradilan', ['umum', 'agama', 'tun', 'militer', 'pusat'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reffsatker');
    }
}
