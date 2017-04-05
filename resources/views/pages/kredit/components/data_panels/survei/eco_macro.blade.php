<?php
	if(!isset($edit)){
		$edit = true;
	}
?>

<div class="row">
	<div class="col-sm-12">
		<h4 class="text-uppercase">Data Ekonomi Makro
			@if(!empty($page_datas->credit['kreditur']['makro']))
				@if($edit == true)
					<span class="pull-right">
						<small>
						<a href="#ekonomi-macro" data-toggle="modal" data-target="#eco_macro" no-data-pjax>
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

@if(empty($page_datas->credit['kreditur']['makro']))
<?php
	$page_datas->credit['kreditur']['makro'] = null;
?>

<!-- No Data -->
<div class="row">
	<div class="col-sm-12">
		<p>Belum ada data disimpan. <a href="#ekonomi-makro" data-toggle="modal" data-target="#eco_macro" no-data-pjax> Tambahkan Sekarang </a></p>
	</div>
</div>
<div class="row clearfix">&nbsp;</div>
<div class="row clearfix">&nbsp;</div>
@else
<!-- With Data -->
<div class="row">
	<div class="col-sm-6">
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Prospek Usaha</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['prospek_usaha']) }}
				</p>
			</div>
		</div>
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Persaingan Usaha</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['persaingan_usaha']) }}
				</p>
			</div>
		</div>
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Perputaran Usaha</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['perputaran_usaha']) }}
				</p>
			</div>
		</div>	
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Jumlah Pelanggan Harian</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['jumlah_pelanggan_harian']) }}
				</p>
			</div>
		</div>	

	</div>


	<div class="col-sm-6">

		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Resiko Usaha</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['resiko_usaha']) }}
				</p>
			</div>
		</div>	
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Pengalaman Usaha</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['pengalaman_usaha']) }}
				</p>
			</div>
		</div>
		<div class="row m-b-xl">
			<div class="col-sm-12">
				<p class="p-b-sm"><strong>Keterangan Lain</strong></p>
				<p>
					{{ ucwords($page_datas->credit['kreditur']['makro']['keterangan']) }}
				</p>
			</div>
		</div>		

	</div>
</div>
@endif

@push('show_modals')
	@if($edit == true)

		<!-- Data ekonomi makro // -->
		@component('components.modal', [
			'id' 		=> 'eco_macro',
			'title'		=> 'Ekonomi Makro',
			'settings'	=> [
				'hide_buttons'	=> true
			]
		])
			@include('pages.kredit.components.survei.form.eco_macro')
		@endcomponent

	@endif
@endpush	