<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Domain\Pengajuan\Models\Pengajuan;
use App\Service\Survei\SurveiKredit;
use App\Service\Pengajuan\UpdateStatusKredit;

use Carbon\Carbon;
use App\Service\Akses\SessionBasedAuthenticator;

class InitPenolakanKreditTableSeeder extends Seeder
{
	public function run()
	{
		//1. simpan imigrasi
		$credentials	=	[
								'nip'				=> '2017.0001',
								'email'				=> 'admin@ksp.id',
								'password'			=> 'admin',
								'nama'				=> 'C Mooy'
							];

		$sba 			= new SessionBasedAuthenticator;
		$sba 			= $sba->login($credentials);

		$pengajuan 		= Pengajuan::where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->where('status', 'survei')->take(Pengajuan::where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->where('status', 'survei')->count()/3)->get();

		foreach ($pengajuan as $key => $value) 
		{
			$ubah 		= new UpdateStatusKredit($value->id);
			$ubah->toTolak();
			$ubah->save();
		}
	}
}
