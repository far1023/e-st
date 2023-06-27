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
		Schema::create('skts', function (Blueprint $table) {
			$table->id();
			$table->text('nama_pemilik');
			$table->text('tempat_lahir_pemilik');
			$table->text('tanggal_lahir_pemilik');
			$table->text('wn_pemilik');
			$table->text('ktp_pemilik');
			$table->text('alamat_pemilik');
			$table->text('jalan_gang');
			$table->text('rt');
			$table->text('rw');
			$table->text('dusun');
			$table->text('desa');
			$table->text('kecamatan');
			$table->text('kabupaten');
			$table->text('pbb')->nullable();
			$table->text('luas_tanah');
			$table->text('peroleh_dari');
			$table->text('tanaman_keras')->nullable();
			$table->text('no_ref')->nullable();
			$table->text('tanggal_ref')->nullable();
			$table->text('batas_utara');
			$table->text('ukuran_utara');
			$table->text('batas_selatan');
			$table->text('ukuran_selatan');
			$table->text('batas_barat');
			$table->text('ukuran_barat');
			$table->text('batas_timur');
			$table->text('ukuran_timur');
			$table->text('nama_saksi_satu')->nullable();
			$table->text('jabatan_saksi_satu')->nullable();
			$table->text('nama_saksi_dua')->nullable();
			$table->text('jabatan_saksi_dua')->nullable();
			$table->text('nama_saksi_tiga')->nullable();
			$table->text('jabatan_saksi_tiga')->nullable();
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
		Schema::dropIfExists('skts');
	}
};
