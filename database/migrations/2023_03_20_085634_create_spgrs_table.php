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
			$table->text('no_reg');
			$table->text('tanggal_reg');
			$table->text('no_ref')->nullable();
			$table->text('tanggal_ref')->nullable();
			$table->text('nama_pihak_pertama');
			$table->text('tempat_lahir_pihak_pertama');
			$table->text('tanggal_lahir_pihak_pertama');
			$table->text('wn_pihak_pertama');
			$table->text('ktp_pihak_pertama');
			$table->text('alamat_pihak_pertama');
			$table->text('nama_pihak_kedua');
			$table->text('tempat_lahir_pihak_kedua');
			$table->text('tanggal_lahir_pihak_kedua');
			$table->text('wn_pihak_kedua');
			$table->text('ktp_pihak_kedua');
			$table->text('alamat_pihak_kedua');
			$table->text('alamat_tanah');
			$table->text('luas_tanah');
			$table->text('pergunaan_tanah');
			$table->text('besaran');
			$table->text('terbilang');
			$table->text('batas_utara');
			$table->text('ukuran_utara');
			$table->text('batas_selatan');
			$table->text('ukuran_selatan');
			$table->text('batas_barat');
			$table->text('ukuran_barat');
			$table->text('batas_timur');
			$table->text('ukuran_timur');
			$table->text('mengetahui');
			$table->date('checked_at')->nullable();
			$table->date('approved_at')->nullable();
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
