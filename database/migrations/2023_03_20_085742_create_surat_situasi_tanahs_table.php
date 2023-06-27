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
		Schema::create('surat_situasi_tanahs', function (Blueprint $table) {
			$table->id();
			$table->text('jalan_gang');
			$table->text('rt');
			$table->text('rw');
			$table->text('desa');
			$table->text('dusun');
			$table->text('kecamatan');
			$table->text('kabupaten');
			$table->text('luas_tanah');
			$table->text('atas_nama');
			$table->text('keterangan')->nullable();
			$table->text('pihak_kedua')->nullable();
			$table->text('sketsa')->nullable();
			$table->text('nama_saksi_satu')->nullable();
			$table->text('jabatan_saksi_satu')->nullable();
			$table->text('nama_saksi_dua')->nullable();
			$table->text('jabatan_saksi_dua')->nullable();
			$table->text('nama_saksi_tiga')->nullable();
			$table->text('jabatan_saksi_tiga')->nullable();
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
		Schema::dropIfExists('surat_situasi_tanahs');
	}
};
