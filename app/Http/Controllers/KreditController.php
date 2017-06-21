<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Domain\Pengajuan\Models\Pengajuan;
use App\Service\Pengajuan\PengajuanKredit;
use App\Service\Helpers\UI\UploadGambar;
use App\Service\Helpers\ACL\KewenanganKredit;

use App\Service\Pengajuan\UpdateStatusKredit;
use App\Service\Pengajuan\HapusDataKredit;

use App\Service\Pengajuan\SurveiKredit;

use App\Service\Helpers\Kredit\JangkaWaktuKredit;
use App\Service\Helpers\Kredit\JenisKredit;
use App\Service\Helpers\Kredit\JenisJaminanKendaraan;
use App\Service\Helpers\Kredit\MerkJaminanKendaraan;

use App\Service\Teritorial\TeritoriIndonesia;

use Input, PDF, Carbon\Carbon, Exception, TAuth;

/**
 * Kelas CreditController
 *
 * Digunakan untuk semua data Kredit.
 *
 * @author     Agil M <agil@thunderlab.id>
 */
class KreditController extends Controller
{
	private $credit_active_filters = [];

	/**
	 * Creates construct from controller to get instate some stuffs
	 */
	public function __construct(Request $request)
	{
		parent::__construct();

		$this->service 		= new Pengajuan;
		$this->request 		= $request;
	}

	/**
	 * lihat semua data kredit
	 *
	 * @return Response
	 */
	public function index()
	{
		$page 				= 1;

		if (Input::has('page'))
		{
			$page 			= (int)Input::get('page');
		}
		// set page attributes (please check parent variable)
		$this->page_attributes->title				= "Daftar Kredit";
		$this->page_attributes->breadcrumb			= 	[
															'Kredit'   => route('credit.index'),
														];

		//this function to set all needed variable in lists credit (sidebar)
		$this->getCreditLists($page, 10);

		// Paginate
		$this->paginate(route('credit.index', $this->credit_active_filters), $this->page_datas->total_credits, $page, 10);

		//initialize view
		$this->view									= view('pages.kredit.index');

		//function from parent to generate view
		return $this->generateView();
	}

	/**
	 * membuat data kredit baru
	 *
	 * @return Response
	 */
	public function create()
	{
		// set page attributes (please check parent variable)
		$this->page_attributes->title 				= "Kredit Baru";
		$this->page_attributes->breadcrumb 			= [
															'Kredit'   => route('credit.create'),
														];
		//initialize view
		$this->view 								= view('pages.kredit.create');
		
		$this->page_datas->credit 					= null;
	
		// get parameter from function getParamToView to parsing view
		$this->getParamToView(['provinsi', 'jangka_waktu', 'jenis_kredit', 'jenis_kendaraan', 'merk_kendaraan', 'jenis_pekerjaan']);
		
		//function from parent to generate view
		return $this->generateView();
	}


	/**
	 * simpan kredit
	 *
	 * @return Response
	 */
	public function store()
	{
		try
		{
			//============ DATA KREDIT ============//
			$kredit		= Input::only('jenis_kredit', 'pengajuan_kredit', 'jangka_waktu');
			
			//============ DATA KREDITUR ============//
			$kredit['kreditur'] 				= Input::get('kreditur');

			// kreditur is e-ktp
			if (!isset($kredit['kreditur']['is_ektp'])) 
			{
				$kredit['kreditur']['is_ektp']	= false; 
			}
			else
			{
				$kredit['kreditur']['is_ektp']	= true;
			}
			$kredit['kreditur']['nik']			= '35-'.$kredit['kreditur']['nik'];

			// check input file foto_ktp
			if (Input::file('kreditur')['foto_ktp'])
			{
				$upload 		= new UploadGambar(Input::file('kreditur')['foto_ktp']);
				$upload 		= $upload->handle();

				$foto_ktp 		= $upload['url'];
			}
			else
			{
				$foto_ktp 		= null;
			}

			//============ DATA JAMINAN ============//
			// JAMINAN KENDARAAN
			$jaminan_kendaraan 	= Input::get('jaminan_kendaraan');
			if (!is_null($jaminan_kendaraan))
			{
				foreach ($jaminan_kendaraan as $k => $v)
				{
					foreach ($v as $k2 => $v2)
					{
						$temp_jaminan_kendaraan[$k2][$k] = $v2;
					}
				}
			}
			else
			{
				$temp_jaminan_kendaraan			= [];
			}

			// JAMINAN TANAH & BANGUNAN
			$jaminan_tanah_bangunan 			= Input::get('jaminan_tanah_bangunan');
			if (!is_null($jaminan_tanah_bangunan))
			{
				foreach ($jaminan_tanah_bangunan as $k => $v)
				{
					foreach ($v as $k2 => $v2)
					{
						if(in_array($k, ['alamat', 'rt', 'rw', 'provinsi', 'regensi', 'distrik', 'desa', 'negara']))
						{
							$temp_jaminan_tanah_bangunan[$k2]['alamat'][$k] = $v2;
						}
						else
						{
							$temp_jaminan_tanah_bangunan[$k2][$k] = $v2;
						}
					}
				}
			}
			else
			{
				$temp_jaminan_tanah_bangunan 	= [];
			}

			$kredit['jaminan_kendaraan']		= $temp_jaminan_kendaraan;
			$kredit['jaminan_tanah_bangunan']	= $temp_jaminan_tanah_bangunan;

			$simpan 	= new PengajuanKredit($kredit['jenis_kredit'], $kredit['jangka_waktu'], $kredit['pengajuan_kredit'], Carbon::now()->format('d/m/Y'), [], null, $foto_ktp, null, null);

			$simpan->setDebitur($kredit['kreditur']['nik'], $kredit['kreditur']['nama'], $kredit['kreditur']['tanggal_lahir'], $kredit['kreditur']['jenis_kelamin'], $kredit['kreditur']['status_perkawinan'], $kredit['kreditur']['telepon'], $kredit['kreditur']['pekerjaan'], $kredit['kreditur']['penghasilan_bersih'], $kredit['kreditur']['is_ektp'], $kredit['kreditur']['alamat']);

			foreach ($temp_jaminan_kendaraan as $key => $value) 
			{
				$simpan->tambahJaminanKendaraan($value['tipe'], $value['merk'], $value['tahun'], $value['nomor_bpkb'], $value['atas_nama']);
			}

			foreach ($temp_jaminan_tanah_bangunan as $key => $value) 
			{
				$simpan->tambahJaminanTanahBangunan($value['tipe'], $value['jenis_sertifikat'], $value['nomor_sertifikat'], $value['masa_berlaku_sertifikat'], $value['atas_nama'], $value['alamat'], $value['luas_bangunan'], $value['luas_tanah']);
			}

			$simpan->save();

			//function from parent to redirecting
			return $this->generateRedirect(route('credit.index'));
		}
		catch (Exception $e)
		{
			if (is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}
		
			return $this->generateRedirect(route('credit.create'));
		}
	}

	/**
	 * update kredit
	 *
	 * @return Response
	 */
	public function update($id)
	{
		try
		{
			//update data kreditur
			if (Input::has('kreditur'))
			{
				$kreditur 							= Input::get('kreditur');

				if (Input::file('kreditur')['foto_ktp'])
				{
					$upload 						= new UploadGambar(Input::file('kreditur')['foto_ktp']);
					$upload 						= $upload->handle();

					$kreditur['foto_ktp'] 			= $upload['url'];
				}

				$kreditur['nik'] 					= '35-'.$kreditur['nik'];
				$simpan 	= new SimpanPengajuanKredit($id, ['kreditur' => $kreditur]);
				$simpan->handle();
			}

			if (Input::has('relasi'))
			{
				$kreditur								= Input::only('relasi');
				// $kreditur['relasi']['nik']			= '35-'.$kreditur['relasi']['nik'];
				// $kreditur['relasi']['telepon']		= '';

				$simpan 	= new SimpanPengajuanKredit($id, ['kreditur' => $kreditur]);
				$simpan->handle();
			}

			//update jaminan
			if (Input::has('pengajuan'))
			{
				$jaminan = Input::only('pengajuan');

				if (isset($jaminan['pengajuan']['jaminan_kendaraan']))
				{
					$jaminan_kendaraan['jaminan_kendaraan']				= $jaminan['pengajuan']['jaminan_kendaraan'];
					$simpan 					= new SimpanPengajuanKredit($id, $jaminan_kendaraan);
					$simpan->handle();
				}

				if (isset($jaminan['pengajuan']['jaminan_tanah_bangunan']))
				{
					$jaminan_tanah_bangunan['jaminan_tanah_bangunan'] 	= $jaminan['pengajuan']['jaminan_tanah_bangunan'];
					$simpan 					= new SimpanPengajuanKredit($id, $jaminan_tanah_bangunan);
					$simpan->handle();
				}
			}

			if (Input::has('jangka_waktu'))
			{
				$simpan 	= new SimpanPengajuanKredit($id, Input::only('tanggal_pengajuan', 'pengajuan_kredit', 'jenis_kredit', 'jangka_waktu'));
				$simpan->handle();
			}

			// aset usaha for survei
			if (Input::has('aset_usaha'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('aset_usaha'));
				$simpan->handle();
			}

			// aset kendaraan for survei
			if (Input::has('aset_kendaraan'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('aset_kendaraan'));
				$simpan->handle();
			}

			// aset tanah & bangunan for survei
			if (Input::has('aset_tanah_bangunan'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('aset_tanah_bangunan'));
				$simpan->handle();
			}

			// jaminan kendaraan for survei
			if (Input::has('jaminan_kendaraan'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('jaminan_kendaraan'));
				$simpan->handle();
			}

			// jaminan tanah & bangunan for survei
			if (Input::has('jaminan_tanah_bangunan'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('jaminan_tanah_bangunan'));
				$simpan->handle();
			}

			// rekening for survei
			if (Input::has('rekening'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('rekening'));
				$simpan->handle();
			}

			// keuangan for survei
			if (Input::has('keuangan'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('keuangan'));
				$simpan->handle();
			}

			// kepribadian for survei
			if (Input::has('kepribadian'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('kepribadian'));
				$simpan->handle();
			}

			// nasabah for survei
			if (Input::has('nasabah'))
			{
				$simpan 	= new SimpanSurveiKredit($id, Input::only('nasabah'));
				$simpan->handle();
			}

			$this->page_attributes->msg['success']		= ['Data berhasil disimpan'];
		
			return $this->generateRedirect(route('credit.show', ['id' => $id]));
		}
		catch (Exception $e)
		{
			if (is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}

			return $this->generateRedirect(route('credit.index'));
		}
	}

	/**
	 * status kredit
	 *
	 * @return Response
	 */
	public function gandakan_survei($dari_id, $ke_id)
	{
		try
		{
			$gandakan 		= new GandakanSurvei($dari_id, $ke_id);
			$gandakan 		= $gandakan->handle();
			$this->page_attributes->msg['success']		= ['Data berhasil disimpan'];
		}
		catch(Exception $e)
		{
			if (is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}
		}

		return $this->generateRedirect(route('credit.show', $this->request->ke_id));
	}

	/**
	 * status kredit
	 *
	 * @return Response
	 */
	public function status($id, $status)
	{
		try
		{
			$status 	= new UpdateStatusKredit($id);
			$notes 		= Input::get("notes");

			if(str_is(strtolower($status), 'survei'))
			{
				$status 	= $status->toSurvei($notes);
			}
			elseif(str_is(strtolower($status), 'menunggu_persetujuan'))
			{
				$status 	= $status->toMenungguPersetujuan($notes);
			}
			elseif(str_is(strtolower($status), 'menunggu_realisasi'))
			{
				$status 	= $status->toMenungguRealisasi($notes);
			}
			elseif(str_is(strtolower($status), 'terealisasi'))
			{
				$status 	= $status->toRealisasi($notes);
			}
			elseif(str_is(strtolower($status), 'tolak'))
			{
				$status 	= $status->toTolak($notes);
			}
			else
			{
				throw new Exception("Invalid Status", 1);
			}
			$this->page_attributes->msg['success']		= ['Status berhasil diupdate'];
		}
		catch(Exception $e)
		{
			if (is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}
		}

		//function from parent to redirecting
		return $this->generateRedirect(route('credit.show', $id));
	}

	/**
	 * lihat data credit tertentu
	 *
	 * @param string $id
	 * @return Response
	 */
	public function show($id)
	{
		$page 										= 1;
		if (Input::has('page'))
		{
			$page 									= (int)Input::get('page');
		}

		// set page attributes (please check parent variable)
		$this->page_attributes->title              = "Daftar Kredit";
		$this->page_attributes->breadcrumb         = [
														'Kredit'   => route('credit.index'),
													 ];



		//this function to set all needed variable in lists credit (sidebar)
		$this->getCreditLists($page, 10);

		// Paginate
		$this->paginate(route('credit.show', array_merge(['id' => $id], $this->credit_active_filters)),$this->page_datas->total_credits,$page,10);

		//parsing master data here
		try
		{
			$this->page_datas->credit				= Pengajuan::id($id)->status(KewenanganKredit::statusLists())->where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->with(['debitur', 'debitur.relasi', 'survei_kepribadian', 'survei_nasabah', 'survei_aset_usaha', 'survei_aset_tanah_bangunan', 'survei_aset_kendaraan', 'jaminan_kendaraan', 'jaminan_kendaraan.survei_jaminan_kendaraan', 'jaminan_tanah_bangunan', 'jaminan_tanah_bangunan.survei_jaminan_tanah_bangunan', 'survei_rekening', 'survei_keuangan', 'marketing'])->first();
		}
		catch(Exception $e)
		{
			if (is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}
		
			return $this->generateRedirect(route('credit.index'));
		}

		$this->page_datas->id 						= $id;

		// get active address on person
		$person_id 									= $this->page_datas->credit['kreditur']['id'];

		//initialize view
		switch ($this->page_datas->credit['status']) {
			case 'pengajuan':
				$this->view 						= view('pages.kredit.pengajuan');
				break;
			
			case 'survei':
				$this->view                  		= view('pages.kredit.survei');
				break;

			case 'menunggu_persetujuan':
				$this->view 						= view('pages.kredit.menunggu_persetujuan');
				break;

			case 'menunggu_realisasi':
				$this->view 						= view('pages.kredit.menunggu_realisasi');
				break;

			case 'terealisasi':
				$this->view 						= view('pages.kredit.terrealisasi');
				break;	

			default:
				$this->view 						= view('pages.kredit.pengajuan');
				break;
		}

		// get parameter from function getParamToView to parsing view
		$this->getParamToView(['provinsi', 'jenis_kendaraan', 'jenis_kredit', 'jangka_waktu', 'merk_kendaraan', 'jenis_pekerjaan']);

		//function from parent to generate view
		return $this->generateView();
	}

	/**
	 * menghapus credit tertentu
	 *
	 * @param string $id
	 * @return Response
	 */
	public function destroy()
	{
		try {
			$hapus 		= new HapusDataKredit($this->request->kredit_id);

			if($this->request->is('hapus/jaminan/kendaraan/*'))
			{
				$simpan 	= $hapus->hapusJaminanKendaraan($this->request->jaminan_kendaraan_id);
			}

			if($this->request->is('hapus/jaminan/tanah/bangunan/*'))
			{
				$simpan 	= $hapus->hapusJaminanTanahBangunan($this->request->jaminan_tanah_bangunan_id);
			}

			if($this->request->is('hapus/kreditur/relasi/*'))
			{
				$simpan 	= $hapus->hapusRelasiDebitur($this->request->relasi_id);
			}

			if($this->request->is('hapus/survei/aset/usaha/*'))
			{
				$simpan 	= $hapus->hapusSurveiAsetUsaha($this->request->survei_aset_usaha_id);
			}
			if($this->request->is('hapus/survei/aset/kendaraan/*'))
			{
				$simpan 	= $hapus->hapusSurveiAsetKendaraan($this->request->survei_aset_kendaraan_id);
			}
			if($this->request->is('hapus/survei/aset/tanah/bangunan/*'))
			{
				$simpan 	= $hapus->hapusSurveiAsetTanahBangunan($this->request->survei_aset_tanah_bangunan_id);
			}

			if($this->request->is('hapus/survei/jaminan/kendaraan/*'))
			{
				$simpan 	= $hapus->hapusSurveiJaminanKendaraan($this->request->survei_jaminan_kendaraan_id);
			}
			if($this->request->is('hapus/survei/jaminan/tanah/bangunan/*'))
			{
				$simpan 	= $hapus->hapusSurveiJaminanTanahBangunan($this->request->survei_jaminan_tanah_bangunan_id);
			}

			if($this->request->is('hapus/survei/rekening/*'))
			{
				$simpan 	= $hapus->hapusSurveiRekening($this->request->survei_rekening_id);
			}

			if($this->request->is('hapus/survei/kepribadian/*'))
			{
				$simpan 	= $hapus->hapusSurveiKepribadian($this->request->survei_kepribadian_id);
			}
			
			if($this->request->is('hapus/survei/keuangan/*'))
			{
				$simpan 	= $hapus->hapusSurveiKeuangan($this->request->survei_keuangan_id);
			}

			$this->page_attributes->msg['success']		= ['Data berhasil dihapus'];

		} catch (Exception $e) {
			if (is_array($e->getMessage()))
			{
				$this->page_attributes->msg['error'] 	= $e->getMessage();
			}
			else
			{
				$this->page_attributes->msg['error'] 	= [$e->getMessage()];
			}
		}

		//function from parent to redirecting
		return $this->generateRedirect(route('credit.show', $this->request->kredit_id));
	}

	/**
	 * Fungsi ini untuk menampilkan credit lists, fungsi sidebar.
	 * variable filter dan search juga di parse disini
	 * data dari view pages.credit.lists diatur disini
	 */
	private function getCreditLists($page, $take)
	{
		//1. Parsing status
		$status 									= KewenanganKredit::statusLists(); 

		if (Input::has('status'))
		{
			$status 								= Input::get('status');
			$this->credit_active_filters['status'] 	= $status;
		}

		//2. Parsing search box
		if (Input::has('q'))
		{
			$nama 	= Input::get('q');

			$this->page_datas->credits				= $this->service->status($status)->where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->namaDebitur($nama)->with(['debitur'])->paginate($take);
			$this->page_datas->total_credits		= $this->service->status($status)->where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->namaDebitur($nama)->count();

			$this->credit_active_filters['q'] 		= Input::get('q');
		}
		else
		{
			$this->page_datas->credits				= $this->service->status($status)->where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->with(['debitur'])->paginate($take);

			$this->page_datas->total_credits		= $this->service->status($status)->where('akses_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->count();
		}

		//3. Memanggil fungsi filter active
		$this->page_datas->credit_filters 			= $status;
	}

	/**
	 * function checkAllData
	 */
	private function checkAllData($data)
	{
		foreach ($data as $k => $v)
		{
			if (!isset($v['kreditur']['relasi']) || empty($v['kreditur']['relasi']))
			{
				$complete 							= false;  
			}
			else if (!isset($v['jaminan_kendaraan']) || empty($v['jaminan_kendaraan']))
			{
				$complete 							= false;
			}
			else if (!isset($v['jaminan_tanah_bangunan']) || empty($v['jaminan_tanah_bangunan']))
			{
				$complete 						 	= false;
			}
			else
			{
				$complete 							= true;
			}

			if ($complete == false)
			{
				$data[$k]['data_complete']			= false;
			}
		}
		$this->page_datas->credits 					= $data;
	}

	/**
	 * Fungsi untuk menampilkan halaman rencana kredit yang akan di print
	 */
	public function prints($mode, $id)
	{
		// set page attributes (please check parent variable)
		$this->page_attributes->title              = "Daftar Kredit";
		$this->page_attributes->breadcrumb         = [
															'Kredit'   => route('credit.index'),
													 ];

		//initialize view
		$this->view                                = view('pages.kredit.print.'.$mode);

		//parsing master data here
		$this->page_datas->credit 					= $this->service->detailed($id);
		$this->page_datas->id 						= $id;

		// get active address on person
		$person_id 									= $this->page_datas->credit['kreditur']['id'];

		//function from parent to generate view
		return $this->generateView();
	}

	/**
	 * fungsi untuk menjadikan pdf form pengajuan credit
	 */
	public function pdf($id)
	{
		// set page attributes (please check parent variable)
		$this->page_attributes->title              = "Daftar Kredit";
		$this->page_attributes->breadcrumb         = [
															'Kredit'   => route('credit.index'),
													 ];

		//initialize view
		$this->view                                = view('pages.kredit.print');

		//parsing master data here
		$this->page_datas->credit 					= Credit::findByID($id);
		$this->page_datas->id 						= $id;

		// get active address on person
		$person_id 									= $this->page_datas->credit->credit->creditor->id;
		$this->page_datas->creditor_address_active	= Person::findByID($person_id);

		// check address for warrator (penjamin)
		if (($this->page_datas->credit->credit->warrantor))
		{
			$person_id 									= $this->page_datas->credit->credit->warrantor->id;
			$this->page_datas->warrantor_address_active	= Person::findByID($person_id);
			
		}

		//function from parent to generate view
		$pdf = PDF::loadView('pages.kredit.print', ['page_datas' => $this->page_datas]);
		
		return $pdf->stream();
	}

	/**
	 * function set param to view
	 * Description: helper functio to parsing static element to view
	 * paramater: provinsi, jangka_waktu, jenis_kredit, jenis_kendaraan, merk_kendaraan
	 */
	private function getParamToView($element)
	{

		// get parameter provinsi
		if (in_array('provinsi', $element))
		{
			// initialize teritori indonesia
			$teritori									= new TeritoriIndonesia;
			// get data provinsi
			$provinsi 									= collect($teritori->get());
			$provinsi 									= $provinsi->sortBy('nama');

			$this->page_datas->provinsi 				= $provinsi->pluck('nama', 'id');
		}

		// get parameter jangka waktu
		if (in_array('jangka_waktu', $element))
		{
			// - jangka waktu
			$jw 										= new JangkaWaktuKredit;
			$this->page_datas->select_jangka_waktu		= $jw->get();
		}

		if (in_array('jenis_kredit', $element))
		{
			// - jenis kredit
			$jk 										= new JenisKredit;
			$this->page_datas->select_jenis_kredit		= $jk->get();
		}

		if (in_array('jenis_kendaraan', $element))
		{
			// - jenis kendaraan
			$jjk 										= new JenisJaminanKendaraan;
			$this->page_datas->select_jenis_kendaraan	= $jjk->get();
		}

		if (in_array('merk_kendaraan', $element))
		{
			// - merk kendaraan
			$mjk 										= new MerkJaminanKendaraan;
			$this->page_datas->select_merk_kendaraan	= $mjk->get();
		}

		if (in_array('jenis_pekerjaan', $element))
		{
			$jp 										= [
				'tidak_bekerja'		=> 'Belum / Tidak Bekerja',
				'karyawan_swasta'	=> 'Karyawan Swasta',
				'nelayan'			=> 'Nelayan',
				'pegawai_negeri'	=> 'Pegawai Negeri',
				'petani'			=> 'Petani',
				'polri'				=> 'Polri',
				'wiraswasta'		=> 'Wiraswasta',
				'lain_lain'			=> 'Lainnya'
			];
			$this->page_datas->select_jenis_pekerjaan	= $jp;
		}
	}

	/**
	 * function uploadFile
	 * description: helper function to upload file
	 * parameters: input file upload
	 * return $path location file
	 */
	function uploadFile($file, $name, $location)
	{
		$path 			= $file->storeAs('photos', $location . $name . '.jpg');

		return $path;
	}


	/**
	 * Fungsi untuk menampilkan halaman rencana kredit yang akan di print
	 */
	public function print_realisasi($id, $dokumen)
	{
		//check kredit
		$kredit			= $this->service->detailed($id);
		$koperasi 		= Koperasi_RO::id(TAuth::activeOffice()['koperasi']['id'])->first();
		$pimpinan 		= Visa_A::where('immigration_ro_koperasi_id', TAuth::activeOffice()['koperasi']['id'])->where('role', 'pimpinan')->with(['pengguna'])->first()['pengguna'];

		if(!empty($kredit['jaminan_kendaraan']))
		{
			switch (strtolower($dokumen)) 
			{
				case 'berita_acara_penyerahan_jaminan':
					return view('print.realisasi.jaminan_bpkb.berita_acara_penyerahan_jaminan', compact('kredit', 'koperasi', 'pimpinan'));				
					break;
				case 'pernyataan_penjamin_jaminan':
					return view('print.realisasi.jaminan_bpkb.pernyataan_penjamin_jaminan', compact('kredit', 'koperasi', 'pimpinan'));				
					break;
				case 'pernyataan_penjamin':
					return view('print.realisasi.jaminan_bpkb.pernyataan_penjamin', compact('kredit', 'koperasi', 'pimpinan'));				
					break;
				case 'surat_kuasa_beban_fiducia':
					return view('print.realisasi.jaminan_bpkb.surat_kuasa_beban_fiducia', compact('kredit', 'koperasi', 'pimpinan'));				
					break;
				case 'surat_serah_terima_fiducia':
					return view('print.realisasi.jaminan_bpkb.surat_serah_terima_fiducia', compact('kredit', 'koperasi', 'pimpinan'));				
					break;
				case 'surat_perjanjian_kredit':
					return view('print.realisasi.jaminan_bpkb.surat_perjanjian_kredit', compact('kredit', 'koperasi', 'pimpinan'));				
					break;
				
				default:
					throw new Exception("Invalid dokumen", 1);
					break;
			}
		}

		if(!empty($kredit['jaminan_tanah_bangunan']))
		{
			switch (strtolower($dokumen)) 
			{
				case 'pernyataan_penjamin_jaminan':
					return view('print.realisasi.jaminan_sertifikat.pernyataan_penjamin_jaminan', compact('kredit', 'koperasi', 'pimpinan'));
					break;
				case 'pernyataan_penjamin':
					return view('print.realisasi.jaminan_sertifikat.pernyataan_penjamin', compact('kredit', 'koperasi', 'pimpinan'));
					break;
				case 'surat_perjanjian_kredit':
					return view('print.realisasi.jaminan_sertifikat.surat_perjanjian_kredit', compact('kredit', 'koperasi', 'pimpinan'));
					break;
				case 'surat_perjanjian_kredit':
					return view('print.realisasi.jaminan_sertifikat.surat_perjanjian_kredit', compact('kredit', 'koperasi', 'pimpinan'));
					break;
				case 'surat_pemasangan_plang':
					return view('print.realisasi.jaminan_sertifikat.surat_pemasangan_plang', compact('kredit', 'koperasi', 'pimpinan'));
					break;
				
				default:
					throw new Exception("Invalid dokumen", 1);
					break;
			}
		}

	}
}
