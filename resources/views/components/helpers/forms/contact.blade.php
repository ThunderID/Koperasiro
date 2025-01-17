{{-- 
	Plugin Form Contact
	Description: form untuk kontak
	Usage:
	- Param
		$param['prefix']: prefix variable input
 --}}
<div class="template-clone-contact">
	<fieldset class="form-group">
	  	<label class="text-sm">No. Telpon Yang Dapat Dihubungi</label>
		<div class="row">
			<div class="col-xs-12 col-md-5">
				{!! Form::text( (!is_null($param['prefix']) ? $param['prefix'] . '[telepon]' : 'telepon'), (isset($param['data']) ? $param['data'] : null), [
					'id' => (!is_null($param['prefix']) ? $param['prefix'] . '[telepon]' : 'telepon'),
					'class' => 'form-control required auto-tabindex mask-no-handphone thunder-validation-input', 
					'placeholder' => 'Ex. 0341 2339 9001',
					'thunder-validation-rules' => 'required'
				]) !!}
			</div>
			<div class="col-md-2 p-l-none hidden-xs hidden-sm hidden-md hidden-lg">
			  	{{-- <a href="#" class="btn btn-link remove"><i class="fa fa-times"></i> Hapus</a> --}}
			</div>
		</div>
	</fieldset>
</div>