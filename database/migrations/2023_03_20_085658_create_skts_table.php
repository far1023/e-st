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
			$table->string('nama_pemilik');
			$table->string('tempat_lahir_pemilik');
			$table->date('tanggal_lahir_pemilik');
			$table->string('wn_pemilik');
			$table->string('ktp_pemilik');
			$table->string('alamat_pemilik');
			$table->string('jalan_gang');
			$table->string('rt');
			$table->string('rw');
			$table->string('dusun');
			$table->string('desa');
			$table->string('kecamatan');
			$table->string('kabupaten');
			$table->string('pbb')->nullable();
			$table->integer('luas_tanah');
			$table->string('peroleh_dari');
			$table->string('tanaman_keras')->nullable();
			$table->string('no_ref')->nullable();
			$table->date('tanggal_ref')->nullable();
			$table->string('batas_utara');
			$table->integer('ukuran_utara');
			$table->string('batas_selatan');
			$table->integer('ukuran_selatan');
			$table->string('batas_barat');
			$table->integer('ukuran_barat');
			$table->string('batas_timur');
			$table->integer('ukuran_timur');
			$table->string('nama_saksi_satu')->nullable();
			$table->string('jabatan_saksi_satu')->nullable();
			$table->string('nama_saksi_dua')->nullable();
			$table->string('jabatan_saksi_dua')->nullable();
			$table->string('nama_saksi_tiga')->nullable();
			$table->string('jabatan_saksi_tiga')->nullable();
			$table->string('mengetahui');
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
