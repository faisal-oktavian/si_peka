<style>
  .container-table{
    margin: 0px 10px 0px 10px;
  }
  .table-responsive{
    font-size: 12px; 
    margin-top: 0px;
  }
  .table{
    overflow-x: scroll;
  }
  /* thead > tr {
    background-color: #144e7c;
  } */
  /* thead > tr > th {
    color: #ffffff;
    text-align: center;
    font-size: 14px;
  } */
  /* .rak {
    font-weight: bold;
  } */
  /* .provinsi {
    background-color: #a6d7ff;
    color:rgb(0, 0, 0);
  } */
  /* .titik-dua{
    text-align: center;
    width: 20px;
  } */
</style>

<!-- filter -->
<?php require_once 'vf_report_survei.php';?>


<!-- data -->
<div class="container-table">
    <div class="table-responsive">
        <table id="selectedColumn" class="table table-hover table-bordered table-sm table-condensed" cellspacing="0" width="100%" data-ordering="false">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal Input</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Ruangan</th>
                    <th>Kepuasan</th>
                    <th>Layanan Petugas</th>
                    <th>Keterangan</th>
                    <th>Fasilitas</th>
                    <th>Keterangan</th>
                    <th>Prosedur Layanan</th>
                    <th>Keterangan</th>
                    <th>Waktu Layanan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
				<?php
					$no = 0;
					if (count($arr_data) > 0) {
						foreach ($arr_data as $key => $value) {
							foreach ($value as $v_key => $detail) {
								$no++;
				?>						
								<tr>
									<td><?php echo $no; ?></td>
									<td><?php echo $detail['tanggal_input']; ?></td>
									<td><?php echo $detail['no_rm']; ?></td>
									<td><?php echo $detail['nama_pasien']; ?></td>
									<td><?php echo $detail['nama_ruangan']; ?></td>
									<td><?php echo $detail['kepuasan']; ?></td>
									<td><?php echo !empty($detail['layanan_petugas']) ? $detail['layanan_petugas'] : '-'; ?></td>
									<td><?php echo !empty($detail['description_layanan_petugas']) ? $detail['description_layanan_petugas'] : '-'; ?></td>
									<td><?php echo !empty($detail['layanan_fasilitas']) ? $detail['layanan_fasilitas'] : '-'; ?></td>
									<td><?php echo !empty($detail['description_layanan_fasilitas']) ? $detail['description_layanan_fasilitas'] : '-'; ?></td>
									<td><?php echo !empty($detail['layanan_prosedur']) ? $detail['layanan_prosedur'] : '-'; ?></td>
									<td><?php echo !empty($detail['description_layanan_prosedur']) ? $detail['description_layanan_prosedur'] : '-'; ?></td>
									<td><?php echo !empty($detail['layanan_waktu']) ? $detail['layanan_waktu'] : '-'; ?></td>
									<td><?php echo !empty($detail['description_layanan_waktu']) ? $detail['description_layanan_waktu'] : '-'; ?></td>
								</tr>							
				<?php
							}
						}
					}
					else {
				?>
						<tr>
							<td colspan="14">No matching records found</td>
						</tr>
				<?php
					}
				?>
            </tbody>
        </table>
    </div>
</div>