@extends('template.print_template')
@push('content')
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12 text-center"  style="padding-left: 10px; padding-right: 10px;">
			<h4 class="text-capitalize m-b-md" style="background-color: #eee; padding: 5px; font-size: 16px;">Form Survei Kepribadian</h4>
		</div>
	</div>
	@include('pages.kredit.print.components.kepribadian', [
		'datas' => $page_datas->credit['survei_kepribadian']
	])
	<div class="clearfix">&nbsp;</div>
@endpush