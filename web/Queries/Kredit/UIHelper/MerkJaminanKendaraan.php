<?php

namespace TQueries\Kredit\UIHelper;

/**
 * Kelas Merk Jaminan Kendaraan
 *
 * Digunakan generate UI Options.
 *
 * @author     Budi P <budi@thunderlab.id>
 */
class MerkJaminanKendaraan 
{
	/**
	 * Membuat object asset baru dari data array
	 *
	 * @return array $nav
	 */
	public function get()
	{
		return [
					'daihatsu'		=> 'Daihatsu',
					'honda'			=> 'Honda',
					'isuzu'			=> 'Isuzu',
					'kawasaki'		=> 'Kawasaki',
					'kia'			=> 'KIA',
					'mitsubishi'	=> 'Mitsubishi',
					'nissan'		=> 'Nissan',
					'suzuki'		=> 'Suzuki',
					'toyota'		=> 'Toyota',
					'yamaha'		=> 'Yamaha',
					'00000'			=> 'Lainnya',
				]; 
	}
}