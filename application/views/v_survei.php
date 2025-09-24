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
    
    
    /* Placeholder tetap rata tengah & value (tag terpilih) rata kiri*/   
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        text-align: left;
    }
    .select2-selection__placeholder, .select2-container--default .select2-selection--multiple .select2-search__field:empty {
        text-align: center !important;
        width: 100%;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        text-align: left !important;
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: flex-start !important;
        /* padding-left: 4px !important; */
        justify-content: flex-start !important;
        margin: 0px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-search__field:not(:empty) {
        text-align: left !important;
    }
</style>

<div class="card">
    <div class="survey-top-title">
        <img src="<?php echo base_url('application/assets/logo/banner_survei.png'); ?>" alt="Logo Jatim">
    </div>
    <div>
        <p style="font-size: 25px; font-weight:bold; text-align:center;">Survei Kepuasan Pasien</p>

        <!-- fStep 1: Form input pasien -->
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
                    <input type="text" class="form-control" id="no_rm" name="no_rm" placeholder="Masukkan nomor RM pasien" inputmode="numeric" pattern="\d{8}" maxlength="8" minlength="8" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,8);" />
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
                        <!-- Petugas -->
                        <div class="survey-row">
                            <div class="survey-col label">Petugas <br><small>(Keramahan, Sikap, Penampilan)</small></div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_petugas" name="idlayanan_petugas[]" style="width: 100%;" multiple>
                                    <?php
                                        foreach ($layanan->result() as $key => $value) {
                                            echo "<option value='".$value->idlayanan."' data-name='".$value->nama_layanan."'>".$value->nama_layanan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">       
                                <div id="description_petugas_container" class="description-input-container">
                                    <!-- Input deskripsi dinamis akan ditambahkan di sini oleh JS -->
                                </div>
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div class="survey-row">
                            <div class="survey-col label">Fasilitas</div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_fasilitas" name="idlayanan_fasilitas[]" style="width: 100%;" multiple>
                                    <?php 
                                        foreach ($layanan->result() as $key => $value) {
                                            echo "<option value='".$value->idlayanan."'>".$value->nama_layanan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <div id="description_fasilitas_container" class="description-input-container">
                                    <!-- Input deskripsi dinamis akan ditambahkan di sini oleh JS -->
                                </div>
                            </div>
                        </div>

                        <!-- Prosedur -->
                        <div class="survey-row">
                            <div class="survey-col label">Prosedur Layanan</div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_prosedur" name="idlayanan_prosedur[]" style="width: 100%;" multiple>
                                    <?php 
                                        foreach ($layanan->result() as $key => $value) {
                                            echo "<option value='".$value->idlayanan."'>".$value->nama_layanan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <div id="description_prosedur_container" class="description-input-container">
                                    <!-- Input deskripsi dinamis akan ditambahkan di sini oleh JS -->
                                </div>
                            </div>
                        </div>

                        <!-- Layanan -->
                        <div class="survey-row">
                            <div class="survey-col label">Waktu Layanan</div>
                            <div class="survey-col">
                                <select class="form-control select2" id="idlayanan_waktu" name="idlayanan_waktu[]" style="width: 100%;" multiple>
                                    <?php 
                                        foreach ($layanan->result() as $key => $value) {
                                            echo "<option value='".$value->idlayanan."'>".$value->nama_layanan."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="survey-col">
                                <div id="description_waktu_container" class="description-input-container">
                                    <!-- Input deskripsi dinamis akan ditambahkan di sini oleh JS -->
                                </div>
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