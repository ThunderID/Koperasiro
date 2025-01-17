<?php

namespace App\Domain\Survei\Models;

use App\Infrastructure\Models\BaseModel;
use App\Infrastructure\Traits\GuidTrait;
use App\Infrastructure\Traits\SurveiTrait;

use App\Infrastructure\Traits\IDRTrait;

use Validator, Exception;

/**
 * Model Keuangan
 *
 * Digunakan untuk menyimpan data alamat
 * Ketentuan : 
 * 	- tidak bisa direct changes, tapi harus melalui fungsi tersedia (aggregate)
 * 	- auto generate id (guid)
 *
 * @package    TKredit
 * @subpackage Survei
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class Keuangan extends BaseModel
{
	use GuidTrait;
	use SurveiTrait;
	
	use IDRTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table				= 'survei_keuangan';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable				=	[
											'id'							,
											'petugas_id'					,
											'pengajuan_id'					,
											'penghasilan_rutin'				,
											'penghasilan_pasangan'			,
											'penghasilan_usaha'				,
											'penghasilan_lain'				,
											'biaya_rumah_tangga'			,
											'biaya_rutin'					,
											'biaya_pendidikan'				,
											'biaya_angsuran'				,
											'biaya_lain'					,
											'sumber_penghasilan_utama'		,
											'jumlah_tanggungan_keluarga'	,
											'uraian'						,
										];
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'penghasilan_rutin'			=> 'numeric',
											'penghasilan_pasangan'		=> 'numeric',
											'penghasilan_usaha'			=> 'numeric',
											'penghasilan_lain'			=> 'numeric',
											'biaya_rumah_tangga'		=> 'numeric',
											'biaya_rutin'				=> 'numeric',
											'biaya_pendidikan'			=> 'numeric',
											'biaya_angsuran'			=> 'numeric',
											'biaya_lain'				=> 'numeric',
											'sumber_penghasilan_utama'	=> 'max:255',
											'jumlah_tanggungan_keluarga'=> 'numeric',
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

	protected $appends				= 	[
											'total_pendapatan',
											'total_biaya',
											'penghasilan_bersih',
										];
	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/

	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	public function getPenghasilanRutinAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getPenghasilanPasanganAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getPenghasilanUsahaAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getPenghasilanLainAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getBiayaRumahTanggaAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getBiayaRutinAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getBiayaPendidikanAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getBiayaAngsuranAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getBiayaLainAttribute($value)
	{
		return $this->formatMoneyTo($value);
	}

	public function getTotalPendapatanAttribute($value)
	{
		$total 		= $this->attributes['penghasilan_rutin'] + $this->attributes['penghasilan_pasangan'] + $this->attributes['penghasilan_usaha'] + $this->attributes['penghasilan_lain'];

		return $this->formatMoneyTo($total);
	}

	public function getTotalBiayaAttribute($value)
	{
		$total 		= $this->attributes['biaya_rumah_tangga'] + $this->attributes['biaya_rutin'] + $this->attributes['biaya_pendidikan'] + $this->attributes['biaya_angsuran'] + $this->attributes['biaya_lain'];
		
		return $this->formatMoneyTo($total);
	}

	public function getPenghasilanBersihAttribute($value)
	{
		$total 		= ($this->attributes['penghasilan_rutin'] + $this->attributes['penghasilan_pasangan'] + $this->attributes['penghasilan_usaha'] + $this->attributes['penghasilan_lain']) - ($this->attributes['biaya_rumah_tangga'] + $this->attributes['biaya_rutin'] + $this->attributes['biaya_pendidikan'] + $this->attributes['biaya_angsuran'] + $this->attributes['biaya_lain']);
		
		return $this->formatMoneyTo($total);
	}

	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/

	public function setPenghasilanRutinAttribute($value)
	{
		$this->attributes['penghasilan_rutin']		= $this->formatMoneyFrom($value);
	}

	public function setPenghasilanPasanganAttribute($value)
	{
		$this->attributes['penghasilan_pasangan']	= $this->formatMoneyFrom($value);
	}

	public function setPenghasilanUsahaAttribute($value)
	{
		$this->attributes['penghasilan_usaha']		= $this->formatMoneyFrom($value);
	}

	public function setPenghasilanLainAttribute($value)
	{
		$this->attributes['penghasilan_lain']		= $this->formatMoneyFrom($value);
	}

	public function setBiayaRumahTanggaAttribute($value)
	{
		$this->attributes['biaya_rumah_tangga']		= $this->formatMoneyFrom($value);
	}

	public function setBiayaRutinAttribute($value)
	{
		$this->attributes['biaya_rutin']			= $this->formatMoneyFrom($value);
	}

	public function setBiayaPendidikanAttribute($value)
	{
		$this->attributes['biaya_pendidikan']		= $this->formatMoneyFrom($value);
	}

	public function setBiayaAngsuranAttribute($value)
	{
		$this->attributes['biaya_angsuran']			= $this->formatMoneyFrom($value);
	}

	public function setBiayaLainAttribute($value)
	{
		$this->attributes['biaya_lain']				= $this->formatMoneyFrom($value);
	}

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
}
