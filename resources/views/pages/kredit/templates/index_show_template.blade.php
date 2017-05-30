@php
	$color_switcher 	= [
			'survei' 				=> '#FCA985',
			'tolak' 				=> '#F98CB6',
			'menunggu_persetujuan' 	=> '#48B5A3',
			'menunggu_realisasi' 	=> '#48B5A3',
			'terealisasi' 			=> '#48B5A3',
			'pengajuan'				=> '#0BB7D6',
	];
@endphp
@inject('cservice', 'TQueries\Kredit\DaftarKredit')

@extends('template.cms_template')

@section('kredit')
	active in
@stop

@section('data_kredit')
	active
@stop

@push('content')
	<div class="row field">
		<div class="{{ (isset($page_datas->credit['kreditur']['id']) ? 'hidden-xs' : '') }} col-sm-3 content-sidebar">
			<div class="sidebar-header p-b-sm">
				@include('components.sidebar.basic_header',[ 'param' => [
					'title' 			=> 'Data Kredit',
					'status'			=> 	$cservice->statusLists(),
					'status_default'	=> 'semua'
				]])
			</div>

			<div class="sidebar-content _window" data-padd-top="auto" data-padd-bottom="39">
				<div class="list-group">
				    @foreach($page_datas->credits as $key => $value)
				        <a href="{{ route('credit.show', array_merge(['id' => $value['id']], Input::all())) }}" class="list-group-item {{ $key == 0? 'first': '' }} {{ ((isset($page_datas->id) && $page_datas->id == $value['id']) ? 'active' : '') }}">
				            <h4 class="list-group-item-heading">
				                {{ $value['kreditur']['nama'] }} 
								<span class="badge pull-right" style="background-color:{{ $color_switcher[$value['status']] }};">
									{{ $value['status'] }}
								</span>
				            </h4>
				            <p>{{$value['nomor_kredit']}}</p>
				            <p class="list-group-item-text p-t-xs">
				            	{{ $value['pengajuan_kredit'] }}
				                <span class="pull-right">{{$value['tanggal']}}</span>
				            </p>
				        </a>
				    @endforeach
				</div>
			</div>
			<div class="sidebar-footer">
				<div class="col-md-12 text-center">
					@include('components.custom_paginator',[
						'range' 	=> 5
					])
				</div>
			</div>			
		</div>
		<div class="col-xs-12 col-sm-9">

			@if (isset($page_datas->credit['kreditur']['id']))
				@if ($page_datas->credit['status'] == 'pengajuan')
					@include('pages.kredit.components.top_menu.pengajuan')
				@elseif ($page_datas->credit['status'] == 'survei')
					@include('pages.kredit.components.top_menu.survei')
				@elseif ($page_datas->credit['status'] == 'realisasi')
					@include('pages.kredit.components.top_menu.realisasi')
				@else
					@include('pages.kredit.components.top_menu.tolak')
				@endif
			@endif

			<div class="row _window" data-padd-top="auto" data-padd-bottom="39" style="padding:16px;overflow-y: auto;">
					@yield('page_content')
			</div>

			@if(isset($page_datas->credit['kreditur']['id']))
				@if($page_datas->credit['status'] == 'pengajuan')
					@include('pages.kredit.components.bottom_menu.pengajuan')
				@elseif($page_datas->credit['status'] == 'survei')
					@include('pages.kredit.components.bottom_menu.survei')
				@elseif($page_datas->credit['status'] == 'realisasi')
					@include('pages.kredit.components.bottom_menu.realisasi')
				@else
					@include('pages.kredit.components.bottom_menu.'.$page_datas->credit['status_sebelumnya'])
				@endif
			@endif
				
		</div>
	</div>  
@endpush

@push('modals')
	@yield('page_modals')
@endpush