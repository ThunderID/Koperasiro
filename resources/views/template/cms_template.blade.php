<?php
/*
	==============================================================
	Readme 
	==============================================================
	How to use?
	--------------------------------------------------------------
	Extend this template inside your blade page.
	example:
	@extends('template.cms_template')

	--------------------------------------------------------------
	Requirements
	--------------------------------------------------------------
	To use this layout, you need to  fulfill this following 
	required variable to get this layout working correctly, if not
	it will only display blank value.
	
	This list show required parameter which are encapsulated by
	$page_attributes variables. 

	1. Title
	Description : set value of the page title
	Type 		: String
	Format 		: Case sensitive. No any string operation, what 
				  you write is what you get. 

	2. Breadcrumb
	Description : set value of the breadcrumb
	Type 		: Array of breadcrumb
	Format 		: [
					Bread crumb label => Routing,
					Bread crumb label => Routing,
					and so on....
				  ] 

	--------------------------------------------------------------
	Stacks
	--------------------------------------------------------------
	1. modals
	Description: this where you can push your required modals you 
				 need from your page view.

	2. scripts
	Description: this where you can push your required scripts 
				 you need from your page view.		

	3. Content
	Description: here you can insert your html code of your 
				 content page				 		 

	==============================================================
*/
?>

@extends('layout.layout')

@section('template-styles')
	@stack('styles')
@endsection

@section('template')
	<!-- This for pjax fragment replacement -->
	<div id="pjax-container">

		<!-- Topbar -->
		@include('components.admin_topbar')

		<!-- Navigation -->
		@include('components.navigation')

		<!-- Content -->
		<div class="panel-workspace">
			<div class="panel-workspace-container">
				<div class="panel-workspace-content">
					@stack('content')
				</div>
			</div>
		</div>

		@stack('modals')

		@include('components.push_notification')

	<!-- End of pjax fragment replacement -->
	</div>

	@component('components.modal', [
			'id'			=> 'modal-delete',
			'title'			=> 'Hapus Data',
			'settings'		=> [
				'hide_buttons' => 'false'
			]
		])
		<div class="modal-footer">
			<form action="" class="form form-delete" method="delete" no-data-pjax>
				<div class="form-group text-left">
					<label class="text-light">Masukkan password untuk menghapus data ini</label>
					{!! Form::password('password', ['class' => 'form-control set-focus', 'placeholder' => '**********']) !!}
				</div>
				<a type='button' class="btn btn-default" data-dismiss='modal' no-data-pjax>
					Batal
				</a>
				{!! Form::submit('Hapus', ['class' => 'btn btn-danger']) !!}
			</form>
		</div>		
	@endcomponent

	{{-- modal change koperasi --}}
	@component('components.modal', [
			'id'			=> 'modal-change-koperasi',
			'title'			=> 'Pindah Koperasi',
			'settings'		=> [
				'hide_buttons'	=> true
			]
		])
		<div id="list-koperasi">
			<div class="form-group has-feedback">
				<input type="text" class="search form-control" placeholder="cari nama koperasi">
				<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
			</div>
			<ul class="list-group list">
				@foreach(TAuth::loggedUser()['visas'] as $key => $value)
					<li class="list-group-item">
						<a class="name" href="{{ route('office.activate', ['idx' => $value['id']]) }}" ><i class="fa fa-building"></i>&nbsp;&nbsp; {{ $value['koperasi']['nama'] }}</a>
					</li>
				@endforeach
			</ul>
		</div>
		
		<div class="clearfix">&nbsp;</div>
		<div class="modal-footer" style="margin-left: -15px; margin-right: -15px;">
			<p class="text-left m-b-none">
				<span class="label label-primary">Aktif : &nbsp;&nbsp;&nbsp;<i class="fa fa-building"></i>&nbsp;&nbsp;{{ TAuth::activeOffice()['koperasi']['nama'] }}
				</span>
			</p>
		</div>
	@endcomponent

	{{-- modal confirmation logout --}}
	@component('components.modal', [
			'id'			=> 'modal-logout',
			'title'			=> 'Logout',
			'settings'		=> [
				'hide_buttons' => 'false'
			]
		])
		<p>Apakah anda ingin Logout ?</p>
		</div>
		<div class="modal-footer">
			<a type='button' class="btn btn-default" data-dismiss='modal' no-data-pjax>
				Batal
			</a>
			<a href="{{ route('login.destroy') }}" type="button" class="btn btn-danger" no-data-pjax>Logout
			</a>
		</div>		
	@endcomponent

	@component('components.modal', [
		'id'		=> 'menu',
		'title'		=> 'Menu',
		'settings'	=> [
			'modal_class'	=> 'fullscreen',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'true',
		]
	])
		@include('components.modal.admin_topbar')
	@endcomponent
@endsection

@section('template-scripts')
	@stack('scripts')
@endsection