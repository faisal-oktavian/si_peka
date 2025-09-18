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
            <tr>
                <td>
                    <?php echo $responden->row()->petugas_nama_ruangan; ?>
                </td>
                <td>
                    <?php echo $responden->row()->description_petugas; ?>
                </td>
                <td>
                    <?php echo $responden->row()->fasilitas_nama_ruangan; ?>
                </td>
                <td>
                    <?php echo $responden->row()->description_fasilitas; ?>
                </td>
                <td>
                    <?php echo $responden->row()->prosedur_nama_ruangan; ?>
                </td>
                <td>
                    <?php echo $responden->row()->description_prosedur; ?>
                </td>
                <td>
                    <?php echo $responden->row()->waktu_nama_ruangan; ?>
                </td>
                <td>
                    <?php echo $responden->row()->description_waktu; ?>
                </td>
            </tr>
        </table>
    </div>
</div>