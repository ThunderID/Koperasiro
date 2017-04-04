<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKreditSurveiAsetUsahaTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('survei_aset_usaha', function (Blueprint $table) {
			$table->string('id', 255);
			$table->string('survei_id', 255);
			$table->string('alamat_id', 255);
			$table->string('bidang_usaha', 255);
			$table->string('nama_usaha', 255);
			$table->date('tanggal_berdiri');
			$table->string('status', 255);
			$table->string('status_tempat_usaha', 255);
			$table->integer('luas_tempat_usaha');
			$table->integer('jumlah_karyawan');
			$table->double('nilai_aset');
			$table->double('perputaran_stok');
			$table->double('jumlah_konsumen_perbulan');
			$table->integer('jumlah_saingan_perkota');
			$table->text('uraian');
			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
			$table->index(['deleted_at', 'survei_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('survei_aset_usaha');
	}
}