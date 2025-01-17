<?php

namespace App\Service\Teritorial;

///////////////
//   Models  //
///////////////
use App\Domain\Teritori\Models\Provinsi as Model;
use App\Domain\Teritori\Models\Regensi;
use App\Domain\Teritori\Models\Distrik;
use App\Domain\Teritori\Models\Desa;

use Hash, Exception, Session, TAuth;

/**
 * Class Services Application
 *
 * Meyimpan visa dari user tertentu.
 *
 * @package    Thunderlabid
 * @subpackage Application
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class TeritoriIndonesia
{
	public function __construct()
	{
		$this->model 		= new Model;
	}

	/**
	 * this function mean keep executing
	 * @param array $data
	 * 
	 * @return UserDTODataTransformer $data
	 */
	public function get($queries = [])
	{
		$model 		= $this->queries($queries);
		$model		= $model->get();

		return 	$model->toArray();
	}

	/**
	 * this function mean keep executing
	 * @param array $data
	 * 
	 * @return UserDTODataTransformer $data
	 */
	public function count($queries = [])
	{
		$model 		= $this->queries($queries);
		$model		= $model->count();

		return 	$model;
	}

	private function queries($queries)
	{
		$model 					= $this->model;

		//1.check model regensi
		if(isset($queries['regensi_dari']))
		{
			$model 				= new Regensi;
			$model 				= $model->where('territorial_provinsi_id', $queries['regensi_dari']);
		}

		//2.check model distrik
		if(isset($queries['distrik_dari']))
		{
			$model 				= new Distrik;
			$model 				= $model->where('territorial_regensi_id', $queries['distrik_dari']);
		}

		//3.check model desa
		if(isset($queries['desa_dari']))
		{
			$model 				= new Desa;
			$model 				= $model->where('territorial_distrik_id', $queries['desa_dari']);
		}

		//5.check model negara
		if($model instanceOf Model)
		{
			$model 				= $model->where('territorial_negara_id', 'ID');
		}

		//6. if there is name query
		if(isset($queries['temukan_provinsi']))
		{
			$model 				= $model->where('territorial_negara_id', 'ID')->where('nama', 'like', $queries['nama_provinsi']);
		}
		
		if(isset($queries['temukan_regensi']))
		{
			$model 				= new Regensi;
			$model 				= $model->wherehas('provinsi', function($q)use($queries){$q->where('nama', 'like', $queries['nama_provinsi']);});
		}
		
		if(isset($queries['temukan_distrik']))
		{
			$model 				= new Distrik;
			$model 				= $model->wherehas('regensi', function($q)use($queries){$q->where('nama', 'like', $queries['nama_regensi']);});
		}

		if(isset($queries['temukan_desa']))
		{
			$model 				= new Desa;
			$model 				= $model->wherehas('distrik', function($q)use($queries){$q->where('nama', 'like', $queries['nama_distrik']);});
		}

		return $model;
	} 
}
