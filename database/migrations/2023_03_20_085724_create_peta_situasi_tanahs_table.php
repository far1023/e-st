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
		Schema::create('peta_situasi_tanahs', function (Blueprint $table) {
			$table->id();
			$table->string('jalan_gang');
			$table->string('rt');
			$table->string('rw');
			$table->string('desa');
			$table->string('dusun');
			$table->string('kecamatan');
			$table->string('kabupaten');
			$table->integer('luas_tanah');
			$table->string('atas_nama');
			$table->string('sketsa')->nullable();
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
		Schema::dropIfExists('peta_situasi_tanahs');
	}
};
