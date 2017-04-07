{!! Form::hidden('rekening[id]', (isset($data['id']) ? $data['id'] : null)) !!}
<fieldset class="form-group p-b-md">
	<label for="">Nama Bank</label>
	<div class="row">
		<div class="col-md-5">
			{!! Form::select('rekening[nama_bank]', [
				'bca'		=> 'BCA',
				'bni'		=> 'BNI',
				'bri'		=> 'BRI',
				'danamon'	=> 'Danamon',
				'mandiri'	=> 'Mandiri',
				'lain_lain'	=> 'Lainnya',
			], (isset($data['nama_bank']) ? (in_array($data['nama_bank'], ['bca', 'bni', 'bri', 'danamon', 'mandiri']) ? $data['nama_bank'] : 'lain_lain') : 'bca'), 
			['class' => 'form-control auto-tabindex quick-select', 'data-other' => 'input-rekening-nama-bank']) !!} <br/>
			{!! Form::text('rekening[nama_bank]', (isset($data['nama_bank']) ? $data['nama_bank'] : 'bca'), ['class' => 'form-control auto-tabindex m-t-sm input-rekening-nama-bank ' . 
			(in_array($data['nama_bank'], ['bca', 'bni', 'bri', 'danamon', 'mandiri']) ? 'hidden' : !isset($data['nama_bank']) ? 'hidden' : '')]) !!}
		</div>
	</div>
</fieldset>
<fieldset class="form-group">
	<label for="">Atas Nama</label>
	<div class="row">
		<div class="col-md-5">
			{!! Form::text('rekening[atas_nama]', (isset($data['atas_nama']) ? $data['atas_nama'] : null), ['class' => 'form-control auto-tabindex', 'placeholder' => 'atas nama']) !!}
		</div>
	</div>
</fieldset>
<fieldset class="form-group">
	<label for="">Saldo Awal</label>
	<div class="row">
		<div class="col-md-5">
			{!! Form::text('rekening[saldo_awal]', (isset($data['saldo_awal']) ? $data['saldo_awal'] : null), ['class' => 'form-control auto-tabindex mask-money', 'placeholder' => '']) !!}
		</div>
	</div>
</fieldset>
<fieldset class="form-group">
	<label for="">Saldo Akhir</label>
	<div class="row">
		<div class="col-md-5">
			{!! Form::text('rekening[saldo_akhir]', (isset($data['saldo_akhir']) ? $data['saldo_akhir'] : null), ['class' => 'form-control auto-tabindex mask-money', 'placeholder' => '']) !!}
		</div>
	</div>
</fieldset>