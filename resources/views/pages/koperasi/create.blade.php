@extends('template.cms_template')

@push('content')

	<div class="container-fluid _window" data-padd-top="auto" data-padd-bottom="0">

		<div class="row p-b-sm">
			<div class="col-sm-12">
				<h2>Buat Koperasi Baru</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
			{!! Form::open(['url' => route('koperasi.store'), 'data-ajax-submit' => true]) !!}
				<fieldset class="form-group">
					<label class="text-sm">Nama Koperasi</label>
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-5">
							{!! Form::text('nama', $page_datas->data['nama'], ['class' => 'form-control required', 'placeholder' => 'Masukkan nama koperasi']) !!}			
						</div>
					</div>
				</fieldset>

				<fieldset class="gllpLatlonPicker">
					<label class="text-sm">Alamat Lengkap</label>
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-5">
							<div class="input-group">
								{!! Form::text('alamat', $page_datas->data['alamat'], [
									'class' => 'form-control gllpSearchField required', 
									'placeholder' => 'Masukkan alamat',
									'onFocus' => 'geolocate()',
									'id' => 'autocomplete'
								]) !!}			
								<span class="input-group-btn">
							        <button class="btn btn-default gllpSearchButton" type="button" style="padding-bottom: 9px;">
										<i class="fa fa-search" aria-hidden="true"></i>
							        </button>
							    </span>
						    </div>							
						</div>
					</div>
					<br/>
					{{--
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-5">
							<label class="text-sm">Lokasi Dalam Peta</label>
						</div>
					</div>
					--}}
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-5">
							<div class="gllpMap">
								Loading Google Maps
								<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
							</div>
						</div>
					</div>
					<br/>
					{!! Form::hidden('latitude', $page_datas->data['latitude'], ['class' => 'gllpLatitude']) !!}
					{!! Form::hidden('longitude', $page_datas->data['longitude'], ['class' => 'gllpLongitude']) !!}

					<input type="hidden" name="latitude" class="gllpLatitude" value="{{ $page_datas->data['latitude'] }}" />
					<input type="hidden" name="longitude" class="gllpLongitude" value="{{ $page_datas->data['longitude'] }}" />
					<input type="hidden" class="gllpZoom"/>
				</fieldset>

				<fieldset class="form-group">
					<label class="text-sm">Telepon</label>
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-5">
							{!! Form::text('nomor_telepon', $page_datas->data['nomor_telepon'], ['class' => 'form-control required', 'placeholder' => 'Masukkan nomor telepon']) !!}			
						</div>
					</div>
				</fieldset>	

				<fieldset class="form-group">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-5">
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</fieldset>
			{!! Form::close() !!}
			</div>
		</div>

		<br/>

	</div>

@endpush

@section('script-plugins')
	    <script>
	      // This example displays an address form, using the autocomplete feature
	      // of the Google Places API to help users fill in the information.

	      // This example requires the Places library. Include the libraries=places
	      // parameter when you first load the API. For example:
	      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

	      var placeSearch, autocomplete;
	      var componentForm = {
	        street_number: 'short_name',
	        route: 'long_name',
	        locality: 'long_name',
	        administrative_area_level_1: 'short_name',
	        country: 'long_name',
	        postal_code: 'short_name'
	      };

	      function initAutocomplete() {
	        // Create the autocomplete object, restricting the search to geographical
	        // location types.
	        autocomplete = new google.maps.places.Autocomplete(
	            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
	            {types: ['geocode']});

	        // When the user selects an address from the dropdown, populate the address
	        // fields in the form.
	        autocomplete.addListener('place_changed', fillInAddress);
	      }

	      function fillInAddress() {
	        // Get the place details from the autocomplete object.
	        var place = autocomplete.getPlace();

	        for (var component in componentForm) {
	          document.getElementById(component).value = '';
	          document.getElementById(component).disabled = false;
	        }

	        // Get each component of the address from the place details
	        // and fill the corresponding field on the form.
	        for (var i = 0; i < place.address_components.length; i++) {
	          var addressType = place.address_components[i].types[0];
	          if (componentForm[addressType]) {
	            var val = place.address_components[i][componentForm[addressType]];
	            document.getElementById(addressType).value = val;
	          }
	        }
	      }

	      // Bias the autocomplete object to the user's geographical location,
	      // as supplied by the browser's 'navigator.geolocation' object.
	      function geolocate() {
	        if (navigator.geolocation) {
	          navigator.geolocation.getCurrentPosition(function(position) {
	            var geolocation = {
	              lat: position.coords.latitude,
	              lng: position.coords.longitude
	            };
	            var circle = new google.maps.Circle({
	              center: geolocation,
	              radius: position.coords.accuracy
	            });
	            autocomplete.setBounds(circle.getBounds());
	          });
	        }
	      }
	    </script>
	<script src="/js/jquery-2.1.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhGU-wSjC89hoHPStx7bYGOjHpULJQHGI&libraries=places&callback=initAutocomplete"
	        async defer></script>
@stop