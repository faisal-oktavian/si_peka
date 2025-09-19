<style>
    @media (min-width: 992px) {
        .modal-lg {
            width: 80% !important;
        }
    }
</style>

<div class="row">
    <div class="col-md-12">
        <table>
            <tr>
                <td>Nama Pasien</td>
                <td>&nbsp; : &nbsp;</td>
                <td><?php echo $responden->row()->nama_pasien; ?></td>
            </tr>
            <tr>
                <td>Nomor RM</td>
                <td>&nbsp; : &nbsp;</td>
                <td><?php echo $responden->row()->no_rm; ?></td>
            </tr>
            <tr>
                <td>Kepuasan</td>
                <td>&nbsp; : &nbsp;</td>
                <td><?php echo $responden->row()->kepuasan; ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="auto">Layanan Petugas</th>
                <th width="auto">Keterangan</th>
                <th width="auto">Fasilitas</th>
                <th width="auto">Keterangan</th>
                <th width="auto">Prosedur Layanan</th>
                <th width="auto">Keterangan</th>
                <th width="auto">Waktu Layanan</th>
                <th width="auto">Keterangan</th>
            </tr>

            <?php
                foreach ($arr_data as $key => $value) {
            ?>
                    <tr>
                        <td>
                            <?php echo !empty($value['layanan_petugas']) ? $value['layanan_petugas'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['description_layanan_petugas']) ? $value['description_layanan_petugas'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['layanan_fasilitas']) ? $value['layanan_fasilitas'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['description_layanan_fasilitas']) ? $value['description_layanan_fasilitas'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['layanan_prosedur']) ? $value['layanan_prosedur'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['description_layanan_prosedur']) ? $value['description_layanan_prosedur'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['layanan_waktu']) ? $value['layanan_waktu'] : '-'; ?>
                        </td>
                        <td>
                            <?php echo !empty($value['description_layanan_waktu']) ? $value['description_layanan_waktu'] : '-'; ?>
                        </td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</div>