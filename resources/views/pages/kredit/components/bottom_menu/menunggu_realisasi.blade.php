<div class="row p-t-none p-b-none step">
	<div class="col-xs-12 col-md-12 p-l-none p-r-none step-content">
		<div class="state text-center {{ ($page_datas->credit['status'] == 'tolak') ? 'failed' : 'complete' }}">1. Pengajuan</div>
		<div class="state text-center {{ ($page_datas->credit['status'] == 'tolak') ? 'failed' : 'complete' }}">2. Survei</div>
		<div class="state text-center {{ ($page_datas->credit['status'] == 'tolak') ? 'failed' : 'complete' }}">3. Menunggu Persetujuan</div>
		<div class="state text-center {{ ($page_datas->credit['status'] != 'tolak') ? 'active' : 'failed' }}">4. Disetujui</div>
		<div class="state text-center">5. Kredit Aktif</div>
		<div class="state text-center">6. Lunas</div>
	</div>
</div>	