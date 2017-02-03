<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Redirect, Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	//public page data
	protected $page_attributes;
	protected $page_datas;

	function __construct() 
	{
		$this->page_attributes 			= new \Stdclass;
		$this->page_datas 				= new \Stdclass;
	}   

	public function generateView(){
		return $this->view
            ->with('page_attributes', $this->page_attributes)
			->with('page_datas', $this->page_attributes)
			;
	} 

	public function generateRedirect($route_to){
		// dd(Request::all());
		// redirecting sequence: error, alert, info, success 

		if(isset($this->page_attributes->msg['error'])){
			return Redirect::back()
					->withInput(Request::all())
					->with('msg', $this->page_attributes->msg)
					;
		}

		if(isset($this->page_attributes->msg['alert'])){
			return Redirect::to($route_to)
					->with('msg', $this->page_attributes->msg)
					;
		}

		if(isset($this->page_attributes->msg['info'])){
			return Redirect::to($route_to)
					->with('msg', $this->page_attributes->msg)
					;
		}

		if(isset($this->page_attributes->msg['success'])){
			return Redirect::to($route_to)
					->with('msg', $this->page_attributes->msg)
					;
		}

		// no message
		return Redirect::to($route_to);
	} 
}
