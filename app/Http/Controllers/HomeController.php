<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TKredit\KreditAktif\Models\KreditAktif_RO;
use App\Domain\Kasir\Models\HeaderTransaksi;
use TAuth;

class HomeController extends Controller
{
	// Construct
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * lihat index
	 *
	 * @return Response
	 */
	public function index()
	{
		$a_of 		= TAuth::activeOffice();

		// set page attributes (please check parent variable)
		$this->page_attributes->title	= "Beranda";

		foreach ($a_of['scopes'] as $key => $value) 
		{
			if(!isset($value['expired_at']) || $value['expired_at'] > Carbon::now()->format('d/m/Y'))
			{
				switch ($value['list']) 
				{
					case 'modifikasi_koperasi': case 'atur_akses' :
						$this->page_attributes->hook[0][0]	='pages.home.widgets.last_login';
						$this->page_attributes->hook[0][1]	='pages.home.widgets.inactive_user';
						break;
					
					case 'pengajuan_kredit' :
						$this->page_attributes->hook[1][0]	='pages.home.widgets.pengajuan_baru';
						break;

					case 'survei_kredit' :
						$this->page_attributes->hook[1][1]	='pages.home.widgets.survei_kredit';
						break;

					case 'setujui_kredit' :
						$this->page_attributes->hook[2][0]	='pages.home.widgets.setujui_kredit';
						break;

					case 'realisasi_kredit' :case 'transaksi_harian' : case 'kas_harian' :
						$this->page_attributes->hook[2][1]	='pages.home.widgets.realisasi_kredit';
						$this->page_attributes->hook[3][0]	='pages.home.widgets.kas_hari_ini';
						break;
					default:
						# code...
						break;
				}
			}
		}

		$this->view						= view('pages.home.index');		
		// $this->view						= view('pages.home.kasir');		

		//initialize view

		//function from parent to generate view
		return $this->generateView();
	}
}
