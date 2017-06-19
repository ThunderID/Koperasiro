<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input, PDF, Carbon\Carbon, Exception, StdClass, TAuth, Redirect;

use TImmigration\Models\Visa_A;
use TImmigration\Models\Koperasi_RO;

/**
 * Kelas KoperasiController
 *
 * Digunakan untuk semua data Kredit.
 *
 * @author     Agil M <agil@thunderlab.id>
 */
class KoperasiController extends Controller
{
	/**
	 * Creates construct from controller to get instate some stuffs
	 */
	public function __construct(Request $request)
	{
		parent::__construct();

		$this->request 		= $request;
	}

	/**
	 * lihat semua data kredit
	 *
	 * @return Response
	 */
	public function index()
	{
		$page_datas 				= new StdClass;
		$page_datas->koperasi 		= Koperasi_RO::paginate();
		
		$page_attributes 			= new StdClass;
		$page_attributes->paging 	= $page_datas->koperasi;

		return view('pages.koperasi.index', compact('page_datas', 'page_attributes'));
	}

	/**
	 * lihat semua data kredit
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$origin_id = TAuth::activeOffice()['koperasi']['id'];
		if($id != $origin_id){
			return Redirect::to(route('koperasi.show', ['id' => $origin_id]));
		}

		$page_datas 				= new StdClass;
		$page_datas->koperasi 		= Koperasi_RO::paginate();
		$page_datas->data 			= Koperasi_RO::findorfail($id);
		$page_datas->id 			= $id;
		$page_datas->users 			= Visa_A::where('immigration_ro_koperasi_id', $id)->with(['pengguna'])->get()->toArray();


		$page_attributes 			= new StdClass;
		$page_attributes->paging 	= $page_datas->koperasi;
		

		return view('pages.koperasi.index', compact('page_datas', 'page_attributes'));
	}


	/**
	 * lihat semua data kredit
	 *
	 * @return Response
	 */
	public function create($id = null)
	{
		$page_datas 				= new StdClass;
		// $page_datas->koperasi 		= Koperasi_RO::paginate();
		$page_datas->data 			= Koperasi_RO::findornew($id);
		$page_datas->id 			= $id;
		
		$page_attributes 			= new StdClass;
		// $page_attributes->paging 	= $page_datas->koperasi;

		return view('pages.koperasi.create', compact('page_datas', 'page_attributes'));
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		try
		{
			if(is_null($id))
			{
				$id 				= str_replace(' ', '', $this->request->get('nama'));
			}

			$data 					= Koperasi_RO::findornew($id);
			$data->fill($this->request->only(['nama', 'alamat', 'nomor_telepon', 'latitude', 'longitude']));
			$data->id 				= $id;
			$data->save();

			$this->page_attributes->msg['success']		= ['Data berhasil disimpan'];

			return $this->generateRedirect(route('koperasi.show', $data->id));
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
		
			return $this->generateRedirect(route('koperasi.create', $id));
		}
	}

	public function update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		try
		{
			$data 					= Koperasi_RO::findorfail($id);
			$data->delete();

			$this->page_attributes->msg['success']		= ['Data berhasil dihapus'];

			return $this->generateRedirect(route('koperasi.index'));
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
		
			return $this->generateRedirect(route('koperasi.show', $id));
		}
	}
}