<form class="form-horizontal az-form" id="form" name="form" method="POST">
	<input type="hidden" name="idkomponen" id="idkomponen">
	<input type="hidden" name="is_copy" id="is_copy">
	<div class="form-group">
		<label class="control-label col-md-4">Nama Komponen <red>*</red></label>
		<div class="col-md-5">
			<input type="text" class="form-control" id="nama_komponen" name="nama_komponen"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-4">Status Kepuasan <red>*</red></label>
		<div class="col-md-5">
			<select class="form-control" name="status_kepuasan" id="status_kepuasan">
				<option value="" disabled>~ Pilih Status ~</option>
				<option value="PUAS">Puas</option>
				<option value="TIDAK PUAS">Tidak Puas</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-4">Wajib Pilih Unit <red>*</red></label>
		<div class="col-md-5">
			<select class="form-control" name="is_unit" id="is_unit">
				<option value="1">Ya</option>
				<option value="0">Tidak</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-4">Urutan <red>*</red></label>
		<div class="col-md-5">
			<input type="text" class="form-control format-number" id="sequence" name="sequence"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-4">Aktif <red>*</red></label>
		<div class="col-md-5">
			<select class="form-control" name="is_active" id="is_active">
				<option value="1">AKTIF</option>
				<option value="0">TIDAK AKTIF</option>
			</select>
		</div>
	</div>
</form>