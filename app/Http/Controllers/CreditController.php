<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Web\Services\Credit;
use App\Web\Services\Person;
use Input;

/**
 * Kelas CreditController
 *
 * Digunakan untuk semua data Credit.
 *
 * @author     Agil M <agil@thunderlab.id>
 */
class CreditController extends Controller
{
	/**
	 * Creates construct from controller to get instate some stuffs
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * lihat semua data credit
	 *
	 * @return Response
	 */
	public function index()
	{
		// set page attributes (please check parent variable)
		$this->page_attributes->title				= "Daftar Kredit";
		$this->page_attributes->breadcrumb			= [
															'Kredit'   => route('credit.index'),
													 ];

		//this function to set all needed variable in lists credit (sidebar)
		$this->getCreditLists();

		//initialize view
		$this->view									= view('pages.credit.index');

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
		$this->view 								= view('pages.credit.create');

		$data										= new \App\UI\CountryLists\Model\Province();
		$this->page_datas->province					= $data->pluck('province_name', 'province_id');

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
		//creditor
		$person['id']			= null;
		$person					= Input::get('person');
		$person['works']		= null;
		$person['relatives']	= null;

		//only happen if person id = null
		if(is_null($person['id']))
		{
			$person_service 	= new Person;
			$person_entity		= $person_service->store($person);
	
			//alamat
			$alamat				= Input::get('alamat');
			$alamat['id']		= null;
			$alamat['latitude']	= null;
			$alamat['longitude']= null;

			$final_entity_person= $person_service->update('alamat', $alamat, $person_entity);
		}

		// warrantor
		$warrantor['id']		= null;
		$warrantor 				= Input::get('warrantor');
	
		if(is_null($warrantor['id']))
		{
			$warrantor['nik']					= null;
			$warrantor['place_of_birth']		= null;
			$warrantor['date_of_birth']			= null;
			$warrantor['religion']				= null;
			$warrantor['highest_education']		= null;
			$warrantor['marital_status']		= null;
			$warrantor['phone_number']			= null;
			$warrantor['works']					= [];
			$warrantor['relatives']				= [];

			$warrantor['gender']				= 'male';

			$warrantor_service 	= new Person;
			$warrantor_entity	= $warrantor_service->store($warrantor);
		}


		//credit
		$credit_array['id']		= null;
		$credit_array			= Input::get('credit');

		$credit_service 		= new Credit;
		$result					= $credit_service->store($credit_array, $person_entity, $warrantor_entity);

		//function from parent to redirecting
		return $this->generateRedirect(route('credit.index'));
	}

	/**
	 * lihat data credit tertentu
	 *
	 * @param string $id
	 * @return Response
	 */
	public function show($id)
	{
		// set page attributes (please check parent variable)
		$this->page_attributes->title              = "Daftar Kredit";
		$this->page_attributes->breadcrumb         = [
															'Kredit'   => route('credit.index'),
													 ];

		//initialize view
		$this->view                                = view('pages.credit.show');

		//this function to set all needed variable in lists credit (sidebar)
		$this->getCreditLists();

		//parsing master data here
		$this->page_datas->credit 					= Credit::findByID($id);
		$this->page_datas->id 						= $id;

		//function from parent to generate view
		return $this->generateView();
	}

	/**
	 * menghapus credit tertentu
	 *
	 * @param string $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//using credit service to delete credit data
		$credit    = Credit::delete($id);

		//function from parent to redirecting
		return $this->generateRedirect(route('credit.index'));
	}

	/**
	 * Fungsi ini untuk menampilkan credit lists, fungsi sidebar.
	 * variable filter dan search juga di parse disini
	 * data dari view pages.credit.lists diatur disini
	 */
	private function getCreditLists()
	{
		//1. Parsing status
		$status 									= null; 
		if(Input::has('status'))
		{
			$status 								= Input::get('status');
		}

		//2. Parsing search box
		if(Input::has('q'))
		{
			$this->page_datas->credits				= Credit::findByName($status, Input::get('q'));
		}
		else
		{
			$this->page_datas->credits				= Credit::all($status);
		}

		//3. Memanggil fungsi filter active
		$this->page_datas->credit_filters 			= Credit::statusLists();
	}
}
