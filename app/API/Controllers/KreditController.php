<?php

namespace App\API\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Thunderlabid\API\Queries\Credit\JSend;
use Thunderlabid\API\Queries\Credit\DaftarKredit;
use Thunderlabid\API\Commands\Credit\AjukanKredit;
use Thunderlabid\API\Commands\Credit\UploadBase64GambarKTP;

use Input;

class KreditController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function __construct(Request $request)
	{
		$this->request 	= $request;
	}

	public function index()
	{
		$data 	= new DaftarKredit;
		
		return JSend::success($data->get(['model' => $this->request->input('model')]))->asArray();
	}

	public function store()
	{
		$kredit 				= Input::get('kredit');
		$kredit['mobile'] 		= Input::get('mobile');
		$kredit['kreditur'] 	= Input::get('kreditur');

		//upload foto ktp
		$ktp 							= base64_decode($kredit['kreditur']['foto_ktp']);
		$data_kredit 					= new UploadBase64GambarKTP($ktp);
		$data_kredit 					= $data_kredit->handle();

		//parse url foto kreditur
		$kredit['kreditur']['foto_ktp']	= $data_kredit['url'];

		$jaminan_kendaraan 		= [];
		$jaminan_tanah_bangunan = [];

		if(!empty($this->request->input('jaminan_kendaraan_1')))
		{
			$jaminan_kendaraan[] 	= $this->request->input('jaminan_kendaraan_1');
		}

		if(!empty($this->request->input('jaminan_kendaraan_2')))
		{
			$jaminan_kendaraan[] 	= $this->request->input('jaminan_kendaraan_2');
		}

		if(!empty($this->request->input('jaminan_tanah_bangunan_1')))
		{
			$jaminan_tanah_bangunan[] 	= $this->request->input('jaminan_tanah_bangunan_1');
		}

		if(!empty($this->request->input('jaminan_tanah_bangunan_2')))
		{
			$jaminan_tanah_bangunan[] 	= $this->request->input('jaminan_tanah_bangunan_2');
		}

		if(!empty($this->request->input('jaminan_tanah_bangunan_3')))
		{
			$jaminan_tanah_bangunan[] 	= $this->request->input('jaminan_tanah_bangunan_3');
		}

		$kredit['jaminan_kendaraan']		= $jaminan_kendaraan;
		$kredit['jaminan_tanah_bangunan']	= $jaminan_tanah_bangunan;

		try {
			$data_kredit 	= new AjukanKredit($kredit);
			$data_kredit 	= $data_kredit->handle();
		} catch (Exception $e) {
			return JSend::error($e->getMessage())->asArray();
		}

		return JSend::success(['nomor_kredit' => $data_kredit['nomor_kredit']])->asArray();
	}

	public function upload($nomor_kredit = null)
	{
		$ktp 			= Input::get('gambar');
		$ktp 			= base64_decode($ktp);

		$data_kredit 	= new UploadBase64GambarKTP($ktp);
		$data_kredit 	= $data_kredit->handle();

		return JSend::success(['url' => $data_kredit['url']])->asArray();
	}
}