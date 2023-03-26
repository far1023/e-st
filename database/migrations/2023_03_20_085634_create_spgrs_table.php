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
		Schema::create('spgrs', function (Blueprint $table) {
			$table->id();
			$table->string('no_reg')->unique();
			$table->string('no_ref')->nullable();
			$table->date('tanggal_ref')->nullable();
			$table->string('nama_pihak_pertama');
			$table->string('tempat_lahir_pihak_pertama');
			$table->date('tanggal_lahir_pihak_pertama');
			$table->string('wn_pihak_pertama');
			$table->string('ktp_pihak_pertama');
			$table->string('alamat_pihak_pertama');
			$table->string('nama_pihak_kedua');
			$table->string('tempat_lahir_pihak_kedua');
			$table->date('tanggal_lahir_pihak_kedua');
			$table->string('wn_pihak_kedua');
			$table->string('ktp_pihak_kedua');
			$table->string('alamat_pihak_kedua');
			$table->string('alamat_tanah');
			$table->integer('luas_tanah');
			$table->integer('besaran');
			$table->string('terbilang');
			$table->string('batas_utara');
			$table->integer('ukuran_utara');
			$table->string('batas_selatan');
			$table->integer('ukuran_selatan');
			$table->string('batas_barat');
			$table->integer('ukuran_barat');
			$table->string('batas_timur');
			$table->integer('ukuran_timur');
			$table->unsignedBigInteger('approved_by')->nullable();
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
		Schema::dropIfExists('spgrs');
	}
};
