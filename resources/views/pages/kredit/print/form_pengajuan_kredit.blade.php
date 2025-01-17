@extends('template.print_template')
@push('content')
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-8 text-right">
			<h4 style="font-size:20px;">FORMULIR PERMOHONAN KREDIT {{str_repeat('&nbsp;&nbsp;&nbsp;', 1)}}</h4>
		</div>
		<div class="col-sm-4 text-left">
			<table style="border:1px solid;width:100%;height:35px;"><tr><td></td></tr></table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 text-center">
			<h4 class="text-capitalize m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">RENCANA KREDIT</h4>
		</div>
	</div>
	@include('pages.kredit.print.components.data_kredit', [
		'datas' => $page_datas->credit
	])

	<div class="row m-t-sm m-b-sm">
		<div class="col-sm-6">
			<h4 class="text-capitalize text-center m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">DATA PRIBADI</h4>
			@include('pages.kredit.print.components.data_pribadi', [
				'datas' => $page_datas->credit['debitur']
			])
		</div>
		<div class="col-sm-6">
			<h4 class="text-capitalize text-center m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">DATA KELUARGA</h4>
			@include('pages.kredit.print.components.data_keluarga', [
				'datas' => $page_datas->credit['debitur']['relasi']
			])
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<h4 class="text-capitalize text-center m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">JAMINAN KENDARAAN</h4>
			@include('pages.kredit.print.components.pengajuan_jaminan_kendaraan', [
				'datas' => $page_datas->credit['jaminan_kendaraan']
			])
		</div>
		<div class="col-sm-6">
			<h4 class="text-capitalize text-center m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">JAMINAN TANAH BANGUNAN</h4>
			@include('pages.kredit.print.components.pengajuan_jaminan_tanah_bangunan', [
				'datas' => $page_datas->credit['jaminan_tanah_bangunan']
			])
		</div>
	</div>

	<!-- AREA TTD -->
	<div class="row">
		<div class="col-sm-12 text-center">
			<h4 class="text-capitalize m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">TANDA TANGAN DAN PERNYATAAN</h4>
		</div>
	</div>

	<div class="row m-l-none m-r-none">
		<div class="col-sm-12 p-l-none p-r-none">
			<p class="word-justify text">
				Surat permonohan ini, saya isi dengan sebenarnya dan saya mengijinkan Pihak Koperasi untuk mendapatkan dan meneliti informasi yang diperlukan serta tidak mewajibkan Pihak Koperasi untuk memberikan penjelasan terhadap segala keputusan yang dikeluarkan. Sehubungan dengan hal ini, saya menyatakan bersedia dan mentaati segala persyaratan dan ketentuan yang berlaku pada Koperasi beserta setiap perubahannya.
			</p>
		</div>
		<div class="col-sm-12 p-l-none p-r-none">
			<p class="text-left text-capitalize text">{{ str_repeat('.', 25) }}, {{ str_repeat('.', 40) }}20....</p>
		</div>
	</div>
	<div class="row m-l-none m-r-none m-b-sm">
		<div class="col-sm-4">
			<p class="text-left text-capitalize" style="font-size: 14px;">Pemohon </p>
			<p class="text">&nbsp;</p>
			<p class="text">&nbsp;</p>
			@if (!empty($page_datas->credit['debitur']['nama']))
				<p class="text-left text-capitalize" style="font-size: 14px;">{{ $page_datas->credit['debitur']['nama'] }}</p>
			@else
				<p class="text-left text-capitalize" style="font-size: 14px;">Nama Jelas : </p>
			@endif
		</div>
		<div class="col-sm-4">
		@if (count($page_datas->credit['debitur']['relasi']))
			<p class="text-left text-capitalize" style="font-size: 14px;">{{ ucwords(str_replace('_', ' ', $page_datas->credit['debitur']['relasi'][0]['pivot']['hubungan'])) }}</p>
			<p class="text">&nbsp;</p>
			<p class="text">&nbsp;</p>
			<p class="text-left text-capitalize" style="font-size: 14px;">{{ $page_datas->credit['debitur']['relasi'][0]['nama'] }} </p>
		@else
			<p class="text-left text-capitalize" style="font-size: 14px;">Suami / Istri / Orang Tua Pemohon *)</p>
			<p class="text">&nbsp;</p>
			<p class="text">&nbsp;</p>
			<p class="text-left text-capitalize" style="font-size: 14px;">Nama Jelas : </p>
		@endif
		</div>
		<div class="col-sm-4">
		@if (count($page_datas->credit['marketing']))
			<p class="text-left text-capitalize" style="font-size: 14px;">Referensi</p>
			<p class="text">&nbsp;</p>
			<p class="text">&nbsp;</p>
			<p class="text-left text-capitalize" style="font-size: 14px;">{{ $page_datas->credit['marketing']['nama'] }} </p>
		@else
			<p class="text-left text-capitalize" style="font-size: 14px;">Referensi</p>
			<p class="text">&nbsp;</p>
			<p class="text">&nbsp;</p>
			<p class="text-left text-capitalize" style="font-size: 14px;">Nama Jelas : </p>
		@endif
		</div>
	</div>

	<!-- AREA CATATAN -->
	<div class="row">
		<div class="col-sm-12 text-center">
			<h4 class="text-capitalize m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">DIISI OLEH KOPERASI</h4>
		</div>
	</div>

	<div class="row m-l-none m-r-none">
		<div class="col-sm-6 p-l-none p-r-none">
			<p class="text-left text-capitalize text">CUSTOMER SERVICE/ADMINISTRASI KREDIT (1) </p>
			<p class="text-left text-capitalize text">Permohonan Kredit diterima oleh &emsp;&nbsp;: </p>
			<p class="text-left text-capitalize text">Tanggal dan Paraf {{str_repeat('&emsp;', 8)}}: </p>
		</div>
		<div class="col-sm-6 p-l-none p-r-none">
			<p class="text-left text-capitalize text">ACCOUNT OFFICER/MARKETING (2) </p>
			<p class="text-left text-capitalize text">Permohonan Kredit diterima oleh &emsp;&nbsp;: </p>
			<p class="text-left text-capitalize text">Tanggal dan Paraf {{str_repeat('&emsp;', 8)}}: </p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
@endpush