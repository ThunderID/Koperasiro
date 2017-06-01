<?php

namespace TCommands\Kredit;

use TKredit\Pengajuan\Models\Pengajuan;
use TKredit\KreditAktif\Models\KreditAktif_RO;
use TKredit\RiwayatKredit\Models\RiwayatKredit_RO;

use App\Domain\Kasir\Models\HeaderTransaksi;
use App\Domain\Kasir\Models\DetailTransaksi;

use Exception, DB, TAuth, Carbon\Carbon, Validator;

class SetujuiKredit
{
	protected $kredit_id;

	/**
	 * Create a new job instance.
	 *
	 * @param  $pengajuan
	 * @return void
	 */
	public function __construct($kredit_id)
	{
		$this->kredit_id	= $kredit_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try
		{
			//check data pengajuan
			$kredit 		= Pengajuan::id($this->kredit_id)->with(['kreditur'])->firstorfail();

			DB::BeginTransaction();

			//1. hapus dokumen sebelumnya
			$kredit_aktif 	= KreditAktif_RO::NomorDokumenKredit($kredit['id'])->delete();

			//2. simpan kredit aktif
			$kaktif			=	[
									'nomor_kredit'			=> 0,
									'nomor_dokumen_kredit'	=> $kredit['id'],
									'pengajuan_kredit'		=> $kredit['pengajuan_kredit'],
									'status'				=> 'menunggu_realisasi',
									'tanggal'				=> $kredit['tanggal_pengajuan'],
									'nama_kreditur'			=> $kredit['kreditur']['nama'],
									'ro_koperasi_id'		=> TAuth::activeOffice()['koperasi']['id'],
									'ro_mobile_model_id'	=> 0,
								];
			$kredit_aktif 	= new KreditAktif_RO;
			$kredit_aktif->fill($kaktif);
			$kredit_aktif->save();

			//3. parse perubahan status
			$riwayat 		= ['status' => 'menunggu_realisasi', 'tanggal' => Carbon::now()->format('d/m/Y'), 'nomor_dokumen_kredit' => $kredit['id']];
			$status 		= new RiwayatKredit_RO;
			$status->fill($riwayat);
			$status->save();

			//4. simpan angsuran
			//4a. check header transaksi
			$ex_header 						= HeaderTransaksi::where('referensi_id', $kredit_aktif->nomor_kredit)->where('tipe', 'bukti_kas_keluar')->first();

			if($ex_header)
			{
				$header 						= new HeaderTransaksi;
				$header->orang_id 				= $kredit->kreditur_id;
				$header->koperasi_id			= $kredit_aktif->ro_koperasi_id;
				$header->referensi_id			= $kredit_aktif->nomor_kredit;
				$header->nomor_transaksi		= 0;
				$header->tipe					= 'bukti_kas_keluar';
				$header->status					= 'pending';
				$header->tanggal_dikeluarkan	= Carbon::now()->format('Y-m-d H:i:s');
				$header->tanggal_jatuh_tempo	= Carbon::parse('+ 1 month')->format('Y-m-d H:i:s');
				$header->save();

				$detail 						= new DetailTransaksi;
				$detail->header_transaksi_id 	= $header->id;
				$detail->deskripsi				= 'Pencairan Kredit';
				$detail->kuantitas				= 1;
				$detail->harga_satuan			= $kredit->pengajuan_kredit;
				$detail->diskon_satuan			= 'Rp 0';
				$detail->save();
			}

			DB::commit();

			return true;
		}
		catch(Exception $e)
		{
			DB::rollback();
			throw $e;
		}
	}
}