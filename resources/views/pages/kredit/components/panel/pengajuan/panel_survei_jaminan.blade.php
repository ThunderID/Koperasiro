<div class="row m-l-none m-r-none m-b-md">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div data-panel="survei-jaminan">
			{{-- include component survei jaminan   --}}
			@include ('pages.kredit.components.data.pengajuan.data_survei_jaminan_kendaraan', [
				'edit' => true
			])

			<hr class="m-b-sm p-b-sm">

			@include ('pages.kredit.components.data.pengajuan.data_survei_jaminan_tanah_bangunan', [
				'edit' => true
			])
		</div>

		{{----------------  FORM SURVEI JAMINAN KENDARAAN  --------------}}
		@if (isset($page_datas->credit['jaminan_kendaraan']))
			@foreach ($page_datas->credit['jaminan_kendaraan'] as $k => $v)
				@foreach($v['survei_jaminan_kendaraan'] as $k2 => $v2)
					<div class="hidden" data-form="survei-jaminan-kendaraan-{{ $k }}-{{ $k2 }}">
						<div class="row">
							<div class="col-sm-12">
								<p class="text-capitalize m-b-sm text-lg">form survei jaminan kendaraan</p>
								<hr/>
							</div>
						</div>
						{!! Form::open(['url' => route('credit.update', ['id' => $page_datas->credit['id']]), 'class' => 'form no-enter', 'method' => 'PUT']) !!}
						
							@include ('pages.kredit.components.form.survei.jaminan_kendaraan', [
								'param'	=> [
									'data'	=> isset($v2) ? $v2 : null,
								]
							])

							<div class="clearfix">&nbsp;</div>
							<div class="text-right">
								<a href="#" class="btn btn-default" data-dismiss="panel" data-panel="survei-jaminan" data-target="survei-jaminan-kendaraan-{{ $k }}-{{ $k2 }}">Batal</a>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</div>
						{!! Form::close() !!}
					</div>
				@endforeach
			@endforeach
		@endif

		<div class="hidden" data-form="survei-jaminan-kendaraan">
			<div class="row">
				<div class="col-sm-12">
					<p class="text-capitalize m-b-sm text-lg">form survei jaminan kendaraan</p>
					<hr/>
				</div>
			</div>
			{!! Form::open(['url' => route('credit.update', ['id' => $page_datas->credit['id']]), 'class' => 'form no-enter', 'method' => 'PUT']) !!}
			
				@include ('pages.kredit.components.form.survei.jaminan_kendaraan', [
					'param'	=> [
						'data'	=> null,
					]
				])

				<div class="clearfix">&nbsp;</div>
				<div class="text-right">
					<a href="#" class="btn btn-default" data-dismiss="panel" data-panel="survei-jaminan" data-target="survei-jaminan-kendaraan">Batal</a>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			{!! Form::close() !!}
		</div>
		{{---------------- // FORM SURVEI JAMINAN KENDARAAN --------------}}

		{{---------------- FORM JAMINAN TANAH & BANGUNAN --------------}}
		@if (isset($page_datas->credit['jaminan_tanah_bangunan']))
			@foreach ($page_datas->credit['jaminan_tanah_bangunan'] as $k => $v)
				@foreach($v['survei_jaminan_tanah_bangunan'] as $k2 => $v2)
				<div class="hidden" data-form="survei-jaminan-tanah-bangunan-{{ $k }}-{{$k2}}">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="text-uppercase">form jaminan tanah bangunan</h4>
							<hr/>
						</div>
					</div>
					{!! Form::open(['url' => route('credit.update', ['id' => $page_datas->credit['id']]), 'class' => 'form no-enter', 'method' => 'PUT']) !!}
						@include ('pages.kredit.components.form.survei.jaminan_tanah_bangunan', [
							'param'	=> [
								'data'	=> isset($v2) ? $v2 : null,
							]
						])

						<div class="clearfix">&nbsp;</div>
						<div class="text-right">
							<a href="#" class="btn btn-default" data-dismiss="panel" data-panel="survei-jaminan" data-target="survei-jaminan-tanah-bangunan-{{ $k }}-{{$k2}}">Batal</a>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					{!! Form::close() !!}
				</div>
				@endforeach
			@endforeach
		@endif

		<div class="hidden" data-form="survei-jaminan-tanah-bangunan">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="text-uppercase">form jaminan tanah bangunan</h4>
					<hr/>
				</div>
			</div>
			{!! Form::open(['url' => route('credit.update', ['id' => $page_datas->credit['id']]), 'class' => 'form no-enter', 'method' => 'PUT']) !!}
				@include ('pages.kredit.components.form.survei.jaminan_tanah_bangunan', [
					'param'	=> [
						'data'	=> null,
					]
				])

				<div class="clearfix">&nbsp;</div>
				<div class="text-right">
					<a href="#" class="btn btn-default" data-dismiss="panel" data-panel="survei-jaminan" data-target="survei-jaminan-tanah-bangunan">Batal</a>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			{!! Form::close() !!}
		</div>
		{{---------------- // FORM JAMINAN TANAH & BANGUNAN --------------}}
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-l-none p-r-none">
		<hr>
	</div>
</div>