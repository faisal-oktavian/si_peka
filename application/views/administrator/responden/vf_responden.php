<form class="form-horizontal">
	<div class="form-group">
		<label class="control-label col-sm-2">Tanggal Input</label>
		<div class="col-md-4">
			<div class="container-date">
				<div class="cd-list">
					<?php echo $date1;?>
				</div>
				<div class="cd-list">s/d</div>
				<div class="cd-list">
					<?php echo $date2;?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Nomor RM</label>
		<div class="col-md-4 col-sm-6">
			<input type="text" class="form-control" name="vf_no_rm" id="vf_no_rm" placeholder="Nomor RM Pasien">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Nama Pasien</label>
		<div class="col-md-4 col-sm-6">
			<input type="text" class="form-control" name="vf_nama_pasien" id="vf_nama_pasien" placeholder="Nama Pasien">
		</div>
	</div>
	<div class="form-group">
        <label class="control-label col-sm-2">Ruangan</label>
        <div class="col-md-4 col-sm-6">
        	<?php echo az_select_nama_ruang('f_ruangan');?>
        </div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">Status</label>
		<div class="col-md-4 col-sm-6">
			<select class="form-control" name="vf_kepuasan" id="vf_kepuasan">
				<option value="">Semua</option>
				<option value="puas">Puas</option>
				<option value="tidak_puas">Tidak Puas</option>
			</select>
		</div>
	</div>
</form>