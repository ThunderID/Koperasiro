<?php

namespace TKredit\Pengajuan\Services;

use TKredit\Pengajuan\Models\Pengajuan;
use TKredit\Pengajuan\Models\Orang as Value;
use TKredit\KreditAktif\Models\KreditAktif_RO;

use DB, Exception;

/**
 * Service PengajuanKreditur
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TKredit
 * @subpackage Pengajuan
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class SimpanPengajuanKreditur
{
	protected $value;
	protected $pengajuan;

	function __construct($pengajuan, $value)
	{
		$this->value 				= $value;
		$this->pengajuan			= $pengajuan;
	}

	public function handle()
	{
		DB::beginTransaction();

		try
		{
			//1. simpan survey
			if($this->pengajuan instanceOf Pengajuan)
			{
				$pengajuan 			= $this->pengajuan;
			}
			else
			{
				$pengajuan 			= Pengajuan::findorfail($this->pengajuan['id']);
			}

			if(isset($pengajuan['kreditur_id']) && $pengajuan['kreditur_id']!="0")
			{
				$kreditur 				= $pengajuan->kreditur;
			}
			elseif($pengajuan['kreditur_id']=="0")
			{
				$kreditur 				= new Value;
			}
			else
			{
				$kreditur 				= Value::findornew($pengajuan['id']);
			}

			$kreditur->fill($this->value);

			if(isset($this->value['relasi']))
			{
				$kreditur->tambahRelasi($this->value['relasi']);
			}

			if(isset($this->value['telepon']))
			{
				$kreditur->setTelepon($this->value['telepon']);
			}

			if(isset($this->value['pekerjaan']))
			{
				$kreditur->setPekerjaan($this->value['pekerjaan']);
			}

			if(isset($this->value['penghasilan_bersih']))
			{
				$kreditur->setPenghasilanBersih($this->value['penghasilan_bersih']);
			}

			if(isset($this->value['foto_ktp']))
			{
				$kreditur->setFotoKTP($this->value['foto_ktp']);
			}

			if(isset($this->value['alamat']))
			{
				$this->value['alamat']['tipe']	= 'rumah';
				
				$kreditur->tambahAlamatRumah($this->value['alamat']);
			}

			$kreditur->save();

			$pengajuan->kreditur_id 	= $kreditur->id;
			$pengajuan->save();

			//update kredit aktif
			$kredit_aktif 				= KreditAktif_RO::NomorDokumenKredit($pengajuan['id'])->get();

			foreach ($kredit_aktif as $key => $value) 
			{
				$value->nama_kreditur 	= $kreditur->nama;

				$value->save();
			}

			DB::commit();
		}
		catch(Exception $e)
		{
dd($e);
			DB::rollback();

			throw $e;
		}

		return true;
	}
}
