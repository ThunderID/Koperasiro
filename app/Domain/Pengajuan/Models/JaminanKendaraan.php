<?php

namespace App\Domain\Pengajuan\Models;

use App\Infrastructure\Models\BaseModel;
use App\Infrastructure\Traits\GuidTrait;

use Validator, Exception;

/**
 * Model JaminanKendaraan
 *
 * Digunakan untuk menyimpan data jaminan kendaraan
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TKredit
 * @subpackage Pengajuan
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class JaminanKendaraan extends BaseModel
{
	use GuidTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'p_jaminan_k';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'id'						,
											'pengajuan_id'				,
											'tipe'						,
											'merk'						,
											'tahun'						,
											'nomor_bpkb'				,
											'atas_nama'					,
										];

	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'tipe'						=> 'required|in:roda_2,roda_3,roda_4,roda_6,lain_lain',
											'merk'						=> 'required',
											// 'merk'					=> 'required|in:honda,yamaha,suzuki,kawasaki,mitsubishi,toyota,nissan,kia,daihatsu,isuzu,lain_lain',
											'tahun'						=> 'max:4|min:4',
											'nomor_bpkb'				=> 'max:255',
											'atas_nama'					=> 'max:255',
										];
	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				= ['created_at', 'updated_at', 'deleted_at'];
	
	/**
	 * data hidden
	 *
	 * @var array
	 */
	protected $hidden				= 	[
											// 'id', 
											'created_at', 
											'updated_at', 
											'deleted_at', 
										];
	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/**
	 * relationship jaminan kendaraan
	 *
	 * @return Kredit $model
	 */	
	public function survei_jaminan_kendaraan()
	{
		return $this->hasMany('App\Domain\Survei\Models\JaminanKendaraan');
	}

	/**
	 * relationship pengajuan
	 *
	 * @return Kredit $model
	 */	
	public function pengajuan()
	{
		return $this->belongsto('App\Domain\Pengajuan\Models\Pengajuan');
	}

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/

	/**
	 * boot
	 * observing model
	 *
	 */	
	public static function boot() 
	{
		parent::boot();
	}

	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/

	public function scopeNomorBPKB($query, $value)
	{
		return $query->where('nomor_bpkb', $value);
	}
}
