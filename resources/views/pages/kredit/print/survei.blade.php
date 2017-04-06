@extends('template.print_template')
@push('content')
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<h1>DATA SURVEI KREDIT</h1>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	
	@include('pages.kredit.print.survei.data_aset_usaha')
	{{-- @include('pages.kredit.print.survei.data_aset_kendaraan')
	@include('pages.kredit.print.survei.data_aset_tanah_bangunan')
	@include('pages.kredit.print.survei.data_jaminan_kendaraan')
	@include('pages.kredit.print.survei.data_jaminan_tanah_bangunan')
	@include('pages.kredit.print.survei.data_rekening')
	@include('pages.kredit.print.survei.data_keuangan') --}}

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	@include('pages.kredit.print.permohonan.surat_pernyataan')

	<div class="row">
		<div class="col-sm-12 text-center">
			<p>{{ TAuth::activeOffice()['koperasi']['nama'] }}, {{ date('d F Y') }}</p>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row text-center">
		<div class="col-sm-4">
			<p>_______________________________</p>
			<p>Referensi</p>
		</div>
		<div class="col-sm-4">
			<p>_______________________________</p>
			<p>Keluarga Pemohon</p>
		</div>
		<div class="col-sm-4">
			<p>_______________________________</p>
			<p>Pemohon</p>
		</div>
	</div>
@endpush