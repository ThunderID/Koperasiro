<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKreditSurveiAsetKendaraanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('s_aset_k', function (Blueprint $table) {
			$table->string('id', 255);
			$table->string('petugas_id', 255);
			$table->string('pengajuan_id', 255);
			$table->string('tipe', 255);
			$table->string('nomor_bpkb', 255);
			$table->text('uraian')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
			$table->index(['deleted_at', 'nomor_bpkb', 'pengajuan_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('s_aset_k');
	}
}