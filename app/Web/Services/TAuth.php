<?php

namespace App\Web\Services;

use Session, Hash, Exception;
use Thunderlabid\Registry\Repository\UserRepository;

/**
 * Kelas Auth
 *
 * Digunakan untuk pengajuan Auth.
 *
 * @author     C Mooy <chelsy@thunderlab.id>
 */
class TAuth 
{
	/**
	 * Mengecek apakah user sedang loging
	 * @return param
	 */
	public static function isLogged()
	{
		if(Session::has('logged.id'))
		{
			try
			{
				$data 	= new UserRepository;
				$data->findByID(Session::get('logged.id'));
			}
			catch(Exception $e)
			{
				throw $e;
			}

			return true;
		}

		throw new Exception("User Tidak Login!", 1);
	}

	/**
	 * Mengecek user yang sedang login
	 *
	 */
	public static function loggedUser()
	{
		$data 	= new UserRepository;

		return $data->findByID(Session::get('logged.id'));
	}

	/**
	 * Mengecek office yang sedang active
	 *
	 */
	public static function activeOffice()
	{
		$acc_id	= Session::get('accesses.idx');

		$data 	= new UserRepository;
		$data 	= $data->findByID(Session::get('logged.id'));
		
		foreach ($data->accesses as $key => $value) 
		{
			if(str_is($value->office->id, $acc_id))
			{
				return $value;
			}
		}

		throw new Exception(" Forbidden ", 1);
	}

	/**
	 * Mengganti setting - an kantor yang active
	 *
	 */
	public static function setOffice($idx)
	{
		Session::put('accesses.idx', $idx);

		return true;
	}

	/**
	 * Autentikasi user yang akan login
	 *
	 * @param array $credentials
	 */
	public static function authenticate($credentials)
	{
		$data 	= new UserRepository;
		
		try
		{
			$data 	= $data->findByEmail($credentials['email']);
		}
		catch(Exception $e)
		{
			throw $e;
		}

		if(!Hash::check($credentials['password'], $data->password))
		{
			throw new Exception("Password Tidak Cocok!", 1);
		}

		Session::put('logged.id', $data->id);
		Session::put('accesses.idx', $data->accesses[0]->office->id);

		return true;
	}

	/**
	 * Membuat object asset baru dari data array
	 *
	 */
	public static function signoff()
	{
		Session::forget('logged.id');

		return true;
	}

	/**
	 * Membuat object asset baru dari data array
	 *
	 */
	public static function allowedCreditStatus()
	{
		if($logged = self::activeOffice())
		{
			switch (strtolower($logged->role)) 
			{
				case 'marketing':
					$status 	= ['drafting'];
					break;
				case 'developer':
					$status 	= ['drafting', 'analizing'];
					break;
				default:
					$status 	= ['drafting'];
					break;
			}

			return $status;
		}
		
		throw new Exception("User not Logged", 1);
	}
}