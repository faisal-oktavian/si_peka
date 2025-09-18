<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.css" type="text/css" />
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/az-core/az-core-left-theme.css" type="text/css" /> -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('<?php echo base_url("application/assets/bg_login.png"); ?>');
        background-size: cover;
        background-position: center;
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
    /* Overlay gelap */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.35);
        z-index: 1;
    }
    body.swal2-height-auto {
        height: 100vh !important;
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    red {
        color: red;
        font-family: 'Poppins', sans-serif;
    }
</style>

<div class="card">
    <div class="survey-top-title">
        <img src="<?php echo base_url('application/assets/logo/banner_survei.png'); ?>" alt="Logo Jatim">
    </div>
    <div>
        <p style="font-size: 25px; font-weight:bold; text-align:center;">Survei Kepuasan Pasien</p>

        <!-- form input pasien -->
        <form class="form-horizontal az-form" id="form-step1" name="form" method="POST">
            <div class="form-group">
                <label class="control-label col-md-4">Nama Pasien <red>*</red></label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Masukkan nama pasien"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">No. RM Pasien <red>*</red></label>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="no_rm" name="no_rm" placeholder="Masukkan nomor RM pasien"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Ruang <red>*</red></label>
                <div class="col-md-5">
                    <select class="form-control select2" id="idruangan" name="idruangan" style="width: 100%;">
                        <option value="" selected disabled hidden> -- Pilih Ruang -- </option>
                        <?php 
                            foreach ($ruangan->result() as $key => $value) {
                                echo "<option value='".$value->idruangan."'>".$value->nama_ruangan."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                <button type="button" class="btn-back" style="background:#6c757d;" onclick="window.location.href='<?php echo site_url(""); ?>'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                <button type="button" class="btn-next" id="btn-next-1">Selanjutnya <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </form>

        <!-- Step 2: Pilih puas/tidak puas -->
        <form id="form-step2" style="display:none;">
            <div class="form-group" style="text-align:center;">
                <label style="font-size:18px;">Bagaimana tingkat kepuasan Anda?</label>

                <div class="kepuasan-wrapper">
                    <button type="button" class="btn-kepuasan" data-value="puas">
                        <img src="<?php echo base_url('application/assets/logo/puas.png'); ?>" alt="Puas">
                        <div>Puas</div>
                    </button>
                    <button type="button" class="btn-kepuasan" data-value="tidak_puas">
                        <img src="<?php echo base_url('application/assets/logo/tidak puas.png'); ?>" alt="Tidak Puas">
                        <div>Tidak Puas</div>
                    </button>
                </div>

                <input type="hidden" name="kepuasan" id="kepuasan">
            </div>

            <div class="nav-btn-wrapper">
                <button type="button" class="btn-back" id="btn-prev-2"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                <button type="button" class="btn-next" id="btn-next-2" disabled>Selanjutnya <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </form>

        <!-- Step 3: Layanan -->
        <form id="form-step3" style="display:none;">
            <div class="form-group" style="margin-top: 30px;">
                <div class="description-puas" >
                    <h2>Terimakasih</h2>
                    <p>Atas Apresiasi Anda</p>
                    <p><em>Mohon Saran Untuk Peningkatan Layanan Kami</em></p>
                </div>
                <div class="description-tidak-puas" style="display:none;" >
                    <h2>Ijinkan Kami Berbenah</h2>
                    <p>Layanan Apa yang Membuat Anda Tidak Puas?</p>
                </div>
                <div style="margin:15px 0;">
                    <div class="survey-table">
                        <div class="survey-row">
                            <div class="survey-col label">Petugas <br><small>(Keramahan, Sikap, Penampilan)</small></div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_petugas" name="idlayanan_petugas" style="width: 100%;">
                                    <option value="" selected disabled hidden> -- Pilih Ruang -- </option>
                                    <?php 
                                        foreach ($ruangan->result() as $key => $value) {
                                            echo "<option value='".$value->idruangan."'>".$value->nama_ruangan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <input type="text" class="form-control" id="description_petugas" name="description_petugas"/>
                            </div>
                        </div>
                        <div class="survey-row">
                            <div class="survey-col label">Fasilitas</div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_fasilitas" name="idlayanan_fasilitas" style="width: 100%;">
                                    <option value="" selected disabled hidden> -- Pilih Ruang -- </option>
                                    <?php 
                                        foreach ($ruangan->result() as $key => $value) {
                                            echo "<option value='".$value->idruangan."'>".$value->nama_ruangan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <input type="text" class="form-control" id="description_fasilitas" name="description_fasilitas"/>
                            </div>
                        </div>
                        <div class="survey-row">
                            <div class="survey-col label">Prosedur Layanan</div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_prosedur" name="idlayanan_prosedur" style="width: 100%;">
                                    <option value="" selected disabled hidden> -- Pilih Ruang -- </option>
                                    <?php 
                                        foreach ($ruangan->result() as $key => $value) {
                                            echo "<option value='".$value->idruangan."'>".$value->nama_ruangan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <input type="text" class="form-control" id="description_prosedur" name="description_prosedur"/>
                            </div>
                        </div>
                        <div class="survey-row">
                            <div class="survey-col label">Waktu Layanan</div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_waktu" name="idlayanan_waktu" style="width: 100%;">
                                    <option value="" selected disabled hidden> -- Pilih Ruang -- </option>
                                    <?php 
                                        foreach ($ruangan->result() as $key => $value) {
                                            echo "<option value='".$value->idruangan."'>".$value->nama_ruangan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <input type="text" class="form-control" id="description_waktu" name="description_waktu"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                <button type="button" class="btn-back" id="btn-prev-3" style="background:#6c757d;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                <button type="submit" class="btn-next">Kirim <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </form>

    </div>
</div>