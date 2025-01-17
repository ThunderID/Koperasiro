<div class="row">
	<div class="col-sm-12">
		<h4 class="text-uppercase">Data Nasabah</h4>
		<hr/>
		@if (isset($page_datas->credit['nasabah']) && !empty($page_datas->credit['nasabah']))
			<p class="text-capitalize text-muted text-sm">disurvei {!! (isset($page_datas->credit['nasabah']['survei']) && !empty($page_datas->credit['nasabah']['survei'])) ? $page_datas->credit['nasabah']['survei']['tanggal_survei'] . ' oleh ' . $page_datas->credit['nasabah']['survei']['petugas']['nama'] . '<span class="text-muted"><em> ( ' . $page_datas->credit['nasabah']['survei']['petugas']['role'] . ' )</span></em>'  : '-'  !!}</p>
		@endif
	</div>
</div>

@if (isset($page_datas->credit['nasabah']) && !empty($page_datas->credit['nasabah']))
	<div class="row p-t-lg m-b-sm">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<p class="text-capitalize text-light">
				Nama
			</p>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<p class="text-capitalize text-light">
				{{ (isset($page_datas->credit['nasabah']['nama']) && !is_null($page_datas->credit['nasabah']['nama'])) ? $page_datas->credit['nasabah']['nama'] : '-' }}
			</p>
		</div>
	</div>
	<div class="row m-b-sm">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<p class="text-capitalize text-light">
				status
			</p>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<p class="text-capitalize text-light">
				{{ (isset($page_datas->credit['nasabah']['status']) && !is_null($page_datas->credit['nasabah']['status'])) ? str_replace('_', ' ', $page_datas->credit['nasabah']['status']) : '-' }}
			</p>
		</div>
	</div>
	<div class="row m-b-sm">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<p class="text-capitalize text-light">
				kredit sebelumnya
			</p>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<p class="text-capitalize text-light">
				{{ (isset($page_datas->credit['nasabah']['kredit_terdahulu']) && !is_null($page_datas->credit['nasabah']['kredit_terdahulu'])) ? str_replace('_', ' ', $page_datas->credit['nasabah']['kredit_terdahulu']) : '-' }}
			</p>
		</div>
	</div>
	<div class="row m-b-sm">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<p class="text-capitalize text-light">
				jaminan sebelumnya
			</p>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<p class="text-capitalize text-light">
				{{ (isset($page_datas->credit['nasabah']['jaminan_terdahulu']) && !is_null($page_datas->credit['nasabah']['jaminan_terdahulu'])) ? $page_datas->credit['nasabah']['jaminan_terdahulu'] : '-' }}
			</p>
		</div>
	</div>
@else
	<!-- No data -->
	<div class="row m-b-xl">
		<div class="col-sm-12">
			<p class="text-light">Belum ada data disimpan. </p>
		</div>
	</div>
@endif

<div class="clearfix m-b-md">&nbsp;</div>