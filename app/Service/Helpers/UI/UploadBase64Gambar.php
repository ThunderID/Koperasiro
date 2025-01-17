<?php

namespace App\Service\Helpers\UI;

use Illuminate\Support\Str;

use Exception, Validator, TAuth, Storage;
use Carbon\Carbon;

class UploadBase64Gambar
{
	protected $file;

	/**
	 * Create a new job instance.
	 *
	 * @param  $file
	 * @return void
	 */
	public function __construct($pre, $file)
	{
		$this->file     		= $file;
		$this->pre     			= $pre;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try
		{
			$rules 		= ['image' => 'required']; 
			//mimes:jpeg,bmp,png and for max size max:10000

			//1. validate file
			$validator	= Validator::make(['image' => $this->file], $rules);

			if(!$validator->passes())
			{
				throw new Exception($validator->messages()->toJson(), 1);
			}
			
			$date 		= Carbon::now();
			$fn 		= $this->pre.'-'.Str::slug(microtime()).'.jpg'; 

			$dp 		= $date->format('Y/m/d');

			if (!file_exists(public_path().'/'.$dp)) 
			{
				mkdir(public_path().'/'.$dp, 0777, true);
			}

			file_put_contents(public_path().'/'.$dp.'/'.$fn, $this->file);
			// $this->file->move(public_path().'/'.$dp, $fn); // uploading file to given path
			
			// Storage::disk('local')->put($fn, $this->file);

			// $kredit = Kredit::nomorkredit($this->nomor_kredit)->firstorfail();
			// $kredit->setKreditur(['foto_ktp' => url('/'.$dp.'/'.$fn), 'is_ektp' => true]);
			// $kredit->save();

			// return $kredit->toArray();
			return ['url' => url('/'.$dp.'/'.$fn)];
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}