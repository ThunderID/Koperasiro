<div class="row p-r-none p-b-none">
	<div class="col-md-12 hidden-md hidden-lg" style="background-color: white; height: 37px;  border-bottom: 1px solid #e6e8e6;">
		<div class="row">
			<div class="col-xs-12">
				<p class="text-muted p-t-sm">
					<span class="p-r-xs"><i class="fa fa-id-card-o"></i> &nbsp; {{ $page_datas->credit['debitur']['nama'] }}</span>-<span class="p-l-xs">{{ $page_datas->credit['debitur']['nik'] }}</span>
				</p>
			</div>
		</div>
	</div>
	<div class="col-md-12 " style="background-color: white; height: 42px; border-bottom: 1px solid #e6e8e6;">
		<div class="row">
			<div class="col-xs-5 col-sm-6  hidden-md hidden-lg">
				<a href="{{ route('credit.index') }}" class="btn primary p-r-sm p-l-none">
					<i class="fa fa-chevron-left"></i> Kembali
				</a>
			</div>
			<div class="col-md-6 col-lg-6 hidden-xs hidden-sm">
				<p class="text-muted p-t-sm text-md">
					<span class="p-r-xs">
						<i class="fa fa-user"></i>&nbsp;&nbsp;
						{{ $page_datas->credit['debitur']['nama'] }}
					</span>
					<span>[ {{ $page_datas->credit['debitur']['nik'] }} ]</span>
				</p>
			</div>
			<div class="col-xs-7 col-sm-6 col-md-6 col-lg-6">
				<!-- <a href="#" data-toggle="modal" data-target="#modal-riwayat-note" class="btn p-r-sm p-l-sm">
					<i class="fa fa-info-circle"></i> Riwayat Note
				</a> -->
				<div class="dropdown pull-right">
					<a class="btn p-r-sm p-l-none primary hidden-xs hidden-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<i class="fa fa-print" aria-hidden="true"></i> Print&nbsp;&nbsp;
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-right fa-ul" aria-labelledby="dropdownMenu1">
						<li class="dropdown-header">Pengajuan</li>
						<li class="m-t-xs m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'pengajuan_kredit', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Pengajuan Kredit
							</a>
						</li>
						<li class="dropdown-header">Survei</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_aset', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Aset
							</a>
						</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_jaminan_kendaraan', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Jaminan Kendaraan
							</a>
						</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_jaminan_tanah_bangunan', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Jaminan Tanah &amp; Bangunan
							</a>
						</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_kepribadian', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Kepribadian
							</a>
						</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_keuangan', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Keuangan
							</a>
						</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_rekening', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Rekening
							</a>
						</li>
						<li class="m-b-xs">
							<a href="#" class="btn-print" data-url="{{ route('credit.print', ['mode' => 'survei_all', 'id' => $page_datas->credit['id']]) }}">
								<i class="fa fa-file-text-o"></i>&nbsp; Form Survei Semua
							</a>
						</li>

						<!-- <li class="dropdown-header">Realisasi</li>
						<li class="m-b-xs">
							<a href="#"><i class="fa fa-file-text-o"></i>&nbsp; Surat PK</a>
						</li> -->
					</ul>
				</div>
				{{-- <a href="#" data-url="{{ route('credit.print', ['mode' => 'pengajuan', 'id' => $page_datas->credit['id']]) }}" class="btn p-r-sm p-l-none primary btn-print hidden-xs hidden-sm">
					<i class="fa fa-print" aria-hidden="true"></i> Print
				</a> --}}
				{{-- <a href="#modal-tolak" data-toggle="modal" data-target="#modal-tolak" class="btn p-r-sm p-l-sm danger">
					<i class="fa fa-times" aria-hidden="true"></i> Tolak
				</a>					
				<a href="{{route('credit.status', ['id' => $page_datas->id, 'status' => 'survei'])}}" data-toggle="modal" data-target="#modal-change-status" class="btn p-r-none p-l-sm success">
					<i class="fa fa-check" aria-hidden="true"></i> Survei
				</a>					 --}}
			</div>
		</div>
	</div>
</div>

@section('page_modals')
	@component('components.modal', [
			'id'			=> 'modal-riwayat-note',
			'title'			=> 'Riwayat Note',
			'settings'		=> [
				'hide_buttons'	=> true
			]
		])
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a type="button" class="btn btn-default" data-dismiss="modal" no-data-pjax="">
						Tutup
					</a>
				</div>
			</div>
		</div>
	@endcomponent

	@component('components.modal', [
			'id'			=> 'modal-change-status',
			'title'			=> ucwords(str_replace('_', ' ', $page_datas->credit['status_berikutnya'])),
			'settings'		=> [
				'hide_buttons'	=> true
			]
		])
		<div class="row">
			<div class="col-md-12">
				{!! Form::open(['url' => route('credit.status', ['id' => $page_datas->credit['id'], 'status' => $page_datas->credit['status_berikutnya']]), 'class' => 'form', 'role' => 'form', 'autocomplete' => 'off', 'data-pjax' => 'true', 'data-ajax-submit' => 'true']) !!}
					<div class="form-group">
						<label for="password">Password</label>
						{!! Form::password('password', ['class' => 'form-control set-focus auto-tabindex', 'placeholder' => 'Masukkan Password Anda', 'required' => 'required']) !!}
					</div>
					<div class="form-group">
						<label for="notes">Catatan</label>
						{!! Form::textarea('notes', null, ['class' => 'form-control auto-tabindex', 'placeholder' => 'Masukan Catatan Tambahan']) !!}
					</div>
					<div class="form-group text-right">
						<a type="button" class="btn btn-default" data-dismiss="modal" no-data-pjax="">
							Batal
						</a>
						{!! Form::submit(ucwords(str_replace('_', ' ', $page_datas->credit['status_berikutnya'])), ['id' => 'btn-login', 'class' => 'btn btn-custom auto-tabindex']) !!}
					</div>
				{!! Form::close() !!}		
			</div>
		</div>

	@endcomponent


	@component('components.modal', [
			'id'			=> 'modal-tolak',
			'title'			=> 'Tolak Kredit',
			'settings'		=> [
				'hide_buttons'	=> true
			]
		])
		<div class="row">
			<div class="col-md-12">
				{!! Form::open(['url' => route('credit.status', ['id' => $page_datas->credit['id'], 'status' => 'tolak']), 'class' => 'form', 'role' => 'form', 'autocomplete' => 'off', 'data-pjax' => 'true', 'data-ajax-submit' => 'true']) !!}
					<div class="form-group">
						<label for="password">Password</label>
						{!! Form::password('password', ['class' => 'form-control set-focus auto-tabindex', 'placeholder' => 'Masukkan Password Anda', 'required' => 'required']) !!}
					</div>
					<div class="form-group">
						<label for="notes">Catatan</label>
						{!! Form::textarea('notes', null, ['class' => 'form-control auto-tabindex', 'placeholder' => 'Masukan Catatan Tambahan']) !!}
					</div>
					<div class="form-group text-right">
						<a type="button" class="btn btn-default" data-dismiss="modal" no-data-pjax="">
							Batal
						</a>
						{!! Form::submit('Tolak', ['class' => 'btn btn-danger auto-tabindex']) !!}
					</div>
				{!! Form::close() !!}		
			</div>
		</div>

	@endcomponent	
@append
