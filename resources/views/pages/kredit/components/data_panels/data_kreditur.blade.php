@php 
	if (!isset($edit))
	{
		$edit = true;
	}
@endphp

<div class="row">
	<div class="col-sm-12">
		<h4 class="text-uppercase">Data Kreditur</h4>
		@if (!is_null($page_datas->credit))
			@if ($edit == true)
				<span class="pull-right">
					<small>
					<a href="#" data-toggle="modal" data-target="#data_aset" no-data-pjax>
						<i class="fa fa-pencil" aria-hidden="true"></i>
						 Edit
					</a>
					</small>
				</span>
			@endif
		@endif
		<hr/>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Nama</strong></p>
				<p>{{ $page_datas->credit['kreditur']['nama'] }}</p>
			</div>
		</div>
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Tanggal Lahir</strong></p>
				<p>
					{{ Carbon\Carbon::parse($page_datas->credit['kreditur']['tanggal_lahir'])->format('d/m/Y') }}
				</p>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Jenis Kelamin</strong></p>
				<p>
					@gender($page_datas->credit['kreditur']['nama'])
				</p>
			</div>
		</div>	
	</div>
</div>

<div class="clearfix hidden-print">&nbsp;</div>

<div class="row">
	<div class="col-sm-12">
	<h5 class="text-uppercase text-light">Kontak</h5>
	</div>
	<div class="col-sm-12">
		<div class="row m-b-xl m-t-xs-m-print">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Nomor Telepon</strong></p>
				@if ($page_datas->credit['kreditur']['telepon'])
					<p>{{ $page_datas->credit['kreditur']['telepon'] }}</p>
				@else
					<p>Belum ada data disimpan. <a class="hidden-print" href="#" data-toggle="modal" data-target="#" no-data-pjax> Tambahkan Sekarang </a></p>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="clearfix hidden-print">&nbsp;</div>

<div class="row">
	<div class="col-sm-12">
		<h5 class="text-uppercase text-light">Alamat</h5>
	</div>
	<div class="col-sm-12">
		<div class="row m-b-xl m-t-xs-m-print">
			<div class="col-sm-12">
				@if (isset($page_datas->credit['kreditur']['alamat']))
					<p class="p-b-sm"><strong>Alamat</strong></p>
					<p class="p-b-xs">{{ $page_datas->credit['kreditur']['alamat']['jalan'] }}, {{ $page_datas->credit['kreditur']['alamat']['desa'] }}, {{ $page_datas->credit['kreditur']['alamat']['distrik'] }}, {{ $page_datas->credit['kreditur']['alamat']['regensi'] }}</p>
					<p class="p-b-xs">{{ $page_datas->credit['kreditur']['alamat']['provinsi'] }} - {{ $page_datas->credit['kreditur']['alamat']['negara'] }}</p>
					<div class="clearfix hidden-print">&nbsp;</div>
					{{-- <h5 class="hidden-print"><a href="#" data-toggle="modal" data-target="#" no-data-pjax data-href="{{route('person.index', ['id' => $page_datas->credit->creditor->id, 'status' => 'rumah'])}}">Lihat Alamat Lain</a></h5> --}}
				@else
					<p>Belum ada data disimpan. <a class="hidden-print" href="#" data-toggle="modal" data-target="#" no-data-pjax> Tambahkan Sekarang </a></p>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="clearfix hidden-print">&nbsp;</div>

<div class="row">
	<div class="col-sm-12">
		<h5 class="text-uppercase text-light">Pekerjaan</h5>
	</div>
	@if (!is_null($page_datas->credit['kreditur']['pekerjaan']))
		<div class="col-sm-6">
			<div class="row m-b-xl m-t-xs-m-print">
				<div class="col-sm-12">
					<p class="p-b-sm"><strong>Jenis Pekerjaan</strong></p>
					<p>{{ ucwords(str_replace('_', ' ', $page_datas->credit['kreditur']['pekerjaan'])) }}</p>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row m-b-xl m-t-xs-m-print">
				<div class="col-sm-12">
					<p class="p-b-sm "><strong>Penghasilan Bersih</strong></p>
					<p>{{ $page_datas->credit['kreditur']['penghasilan_bersih'] }}</p>
				</div>
			</div>				
		</div>
	@else
		<p>Belum ada data disimpan. <a class="hidden-print" href="#" data-toggle="modal" data-target="#" no-data-pjax> Tambahkan Sekarang </a></p>
	@endif
</div>