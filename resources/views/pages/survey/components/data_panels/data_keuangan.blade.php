<?php
	if(!isset($edit)){
		$edit = true;
	}
?>

<div class="row">
	<div class="col-sm-12">
		<h4 class="text-uppercase">Data Keuangan
			@if(count($page_datas->credit->survey->finance->incomes) > 0)
				@if($edit == true)
					<span class="pull-right">
						<small>
							<a href="#data-keuangan" data-toggle="modal" data-target="#data_keuangan" no-data-pjax>
								<i class="fa fa-pencil" aria-hidden="true"></i>
								Edit
							</a>
						</small>
					</span>
				@endif
			@endif
		</h4>
		<hr/>
	</div>
</div>

@if(count($page_datas->credit->survey->finance->incomes) == 0)
<!-- No data -->
<div class="row">
	<div class="col-sm-12">
		<p>Belum ada data disimpan. <a href="#data-keuangan" data-toggle="modal" data-target="#data_keuangan" no-data-pjax> Tambahkan Sekarang </a></p>
	</div>
</div>

<div class="row clearfix">&nbsp;</div>
<div class="row clearfix">&nbsp;</div>

@else
<!-- with data -->
<div class="row">

	<div class="col-sm-12">
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<h4 class="title-section light m-t-none">Penghasilan</h4>
			</hr>
		</div>
	</div>
</div>
@foreach($page_datas->credit->survey->finance->incomes as $income)
<div class="col-sm-6">

	<div class="row m-b-xl">
		<div class="col-sm-12">
			<p class="p-b-sm"><strong>{{ ucwords($income->description ) }}</strong></p>
			<p>
				{{$income->amount->IDR()}}
			</p>
		</div>
	</div>

</div>
@endforeach

<div class="clearfix">&nbsp;</div>

<div class="col-sm-12">
	<div class="row m-b-xl">
		<div class="col-sm-12">
			<h4 class="title-section light m-t-none">Pengeluaran</h4>
		</hr>
	</div>
</div>
</div>

@foreach($page_datas->credit->survey->finance->expenses as $expense)
<div class="col-sm-6">

	<div class="row m-b-xl">
		<div class="col-sm-12">
			<p class="p-b-sm"><strong>{{ ucwords($expense->description ) }}</strong></p>
			<p>
				{{$expense->amount->IDR()}}
			</p>
		</div>
	</div>

</div>
@endforeach

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>

</div>
@endif

@push('show_modals')
	@if($edit == true)

		<!-- Data keuangan // -->
		@component('components.modal', [
			'id' 		=> 'data_keuangan',
			'title'		=> 'Data Keuangan',
			'settings'	=> [
				'hide_buttons'	=> true
			]	
		])
			@include('pages.survey.components.form.data_keuangan')
		@endcomponent	

	@endif
@endpush	