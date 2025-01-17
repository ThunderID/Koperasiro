<div class="row p-b-sm mobile-menu-header">
	<div class="col-xs-2">
	</div>
	<div class="col-xs-12 text-center">
		<span class="pull-left">
			<a href="#" class="text-muted" data-dismiss="modal" style="font-size: 30px;">&times;</a>
		</span>
		<span class="pull-right">
			<a class="text-muted" href="#modal-logout" data-target="#modal-logout" data-toggle="modal" no-data-pjax style="font-size: 20px;">
				<i class="fa fa-power-off" aria-hidden="true" style="margin-top: 8px;"></i>
			</a>
		</span>
		<p class="name text-capitalize m-t-xs m-b-none"><b>{{ $acl_logged_user['nama'] }}</b></p>		
		<p class="role text-capitalize text-muted m-b-none" style="font-size: 12px;">{{ $acl_active_office['role'] }}</p>
	</div>
	<div class="col-xs-2 text-right">
	</div>
</div>
<div class="row p-t-xl">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row m-l-none m-r-none fade" id="main-menu" style="opacity: 1;">
			@foreach(App\Service\Helpers\UI\NavbarService::all() as $key => $item)

				@if (is_null($item['route']))
					<div class="col-xs-6 text-center m-b-lg">
						<a class="btn btn-success btn-block p-t-lg p-b-lg mobile-menu-content menu-content" href="#{{ $key }}-menu" data-menu-to="#{{ $key }}-menu" data-menu-from="#main-menu">
							{{-- <img src="/icons/{{ $key }}.svg" alt="" class="m-b-xs"/><br/> --}}
							{{ ucwords(str_replace('_', ' ', $key)) }}
						</a>
					</div>
						{{-- <ul>
							@foreach ($item['sub'] as $caption => $route)
								<li class="@yield($caption)">
									<a href="{{ $route }}">
										{{ ucwords(str_replace('_', ' ', $caption)) }}
									</a>
								</li>
							@endforeach
						</ul> --}}
				@else
					<div class="col-xs-6 text-center">
						<a class="btn btn-success btn-block p-t-lg p-b-lg mobile-menu-content menu-content" href="{{ $item['route'] }}" data-menu-from="#main-menu">
							<img src="/icons/{{ $key }}.svg" alt="" class="m-b-xs"/><br/>
							{{ ucwords(str_replace('_', ' ', $key)) }}
						</a>
					</div>
				@endif
			@endforeach
		</div>
		@foreach (App\Service\Helpers\UI\NavbarService::all() as $key => $item)
			@if (count($item['sub']) > 0)
				<div class="row m-l-none m-r-none hidden fade" id="{{ $key }}-menu">
					<h4 class="m-l-md m-b-xs text-capitalize"><strong>Menu {{ $key }}</strong></h4>
					<div class="col-xs-12 p-b-xl m-b-xs">
						<a href="#main-menu" class="btn mobile-menu-content p-l-none" data-menu-to="#main-menu" data-menu-from="#{{ $key }}-menu"><i class="fa fa-chevron-left"></i> Kembali</a>
					</div>
					@foreach ($item['sub'] as $caption => $route)
						<div class="col-xs-6 text-center">
							<a href="{{ $route }}" class="btn btn-success btn-block p-t-lg p-b-lg mobile-menu-content menu-content" data-menu-from="#{{ $key }}">
								@if ($caption != 'billing')
									<img src="/icons/{{ $caption }}.svg" alt="" class="m-b-xs"/><br/>
								@endif
								{{ ucwords(str_replace('_', ' ', $caption)) }}
							</a>
						</div>
					@endforeach
				</div>
			@endif
		@endforeach	
		<div class="loading hidden text-center text-muted">
			<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
			<span class="sr-only">Loading...</span>
		</div>
	</div>
</div>