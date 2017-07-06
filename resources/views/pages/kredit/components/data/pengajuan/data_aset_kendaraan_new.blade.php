@php
	if(!isset($edit)){
		$edit = true;
	}
@endphp

<div class="row">
	<div class="col-sm-12">
		<p class="text-capitalize m-b-sm text-lg">data aset kendaraan</p>
	</div>
</div>

{{-- check data aset kendaraan --}}
@if (isset($page_datas->credit['survei_aset_kendaraan']) && !empty($page_datas->credit['survei_aset_kendaraan']))
	{{-- foreach data aset kendaraan --}}
	@forelse ($page_datas->credit['survei_aset_kendaraan'] as $key => $value)
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-capitalize text-muted">
				<p class="m-b-md text-capitalize">
					aset kendaraan {{ $key+1 }}
					@if(!empty($page_datas->credit['survei_aset_kendaraan']))
						@if($edit == true)
							<span class="pull-right">
								<a class="text-danger m-r-md" href="#" data-url="{{ route('survei.aset.kendaraan.destroy', ['kredit_id' => $page_datas->credit['id'], 'survei_aset_kendaraan_id' => $value['id']]) }}" data-toggle="modal" data-target="#modal-delete">
									<i class="fa fa-trash" aria-hidden="true"></i>
									 Hapus
								</a> &nbsp;

								<a href="#aset-kendaraan" data-toggle="hidden" data-target="aset-kendaraan-{{ $key }}" data-panel="data-aset" no-data-pjax>
									<i class="fa fa-pencil" aria-hidden="true"></i>
									 Edit
								</a>
							</span>
						@endif
					@endif
				</p>
				<hr class="m-t-sm m-b-sm"/>
				@if (isset($page_datas->credit['survei_aset_kendaraan']) && !empty($page_datas->credit['survei_aset_kendaraan']))
					@php
						$role 	= \App\Service\Helpers\UI\Inspector::checkOffice($page_datas->credit['survei_nasabah']['surveyor']['visas'], $acl_active_office);
					@endphp

					<p class="text-capitalize text-muted text-sm">
						disurvei {!! (isset($page_datas->credit['survei_nasabah']['surveyor']) && !empty($page_datas->credit['survei_nasabah']['surveyor'])) ? $page_datas->credit['survei_nasabah']['tanggal_survei'] . ' oleh ' . $page_datas->credit['survei_nasabah']['surveyor']['nama'] . '<span class="text-muted"><em> ( ' . $role . ' )</span></em>'  : '-'  !!}
					</p>
				@endif
			</div>
		</div>
		<div class="row p-t-lg">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<p class="text-capitalize text-light">{{ (isset($value['tipe']) && !is_null($value['tipe'])) ? str_replace('_', ' ', $value['tipe']) : '-' }}</p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<p class="m-b-xs text-capitalize text-light">{{ (isset($value['nomor_bpkb']) && !is_null($value['nomor_bpkb'])) ? str_replace('_', ' ', $value['nomor_bpkb']) : '-' }}</p>
				<p class="text-capitalize text-muted text-sm" style="font-size: 11px;"><em>( No. BPKB )</em></p>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
	@empty
		@if ($page_datas->credit['status'] == 'pengajuan')
			<div class="row">
				<div class="col-sm-12">
					<p class="text-light">Maaf data belum tersedia, data akan tersedia setelah data disurvei</p>
				</div>
			</div>
		@else
			<!-- No data -->
			<div class="row m-b-md">
				<div class="col-sm-12">
					<p class="text-light">Belum ada data disimpan. <a href="#aset-kendaraan" data-toggle="hidden" data-target="aset-kendaraan" data-panel="data-aset" no-data-pjax> Tambahkan Sekarang </a></p>
				</div>
			</div>
		@endif
	@endforelse


	@if (count($page_datas->credit['survei_aset_kendaraan']) > 0)
		<div class="row m-t-md m-b-md">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#aset-kendaraan" data-toggle="hidden" data-target="aset-kendaraan" data-panel="data-aset" no-data-pjax><i class="fa fa-plus"></i> Tambahkan Aset Kendaraan</a>
			</div>
		</div>
	@endif
@else
	@if ($page_datas->credit['status'] == 'pengajuan')
		<div class="row">
			<div class="col-sm-12">
				<p class="text-light">Maaf data belum tersedia, data akan tersedia setelah data disurvei</p>
			</div>
		</div>
	@else
		<!-- No data -->
		<div class="row m-b-md">
			<div class="col-sm-12">
				<p class="text-light">Belum ada data disimpan. <a href="#aset-kendaraan" data-toggle="hidden" data-target="aset-kendaraan" data-panel="data-aset" no-data-pjax> Tambahkan Sekarang </a></p>
			</div>
		</div>
	@endif
@endif

<div class="clearfix m-b-md">&nbsp;</div>