<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?php echo base_url().AZAPP_FRONT.'assets/logo/logo saja png.png';?>" />
    <title><?php echo az_get_config('app_name');?> - Survei</title>

    <!-- <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/az-core/az-core.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/az-core/az-core-left-theme.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url().AZAPP;?>assets/plugins/az_theme/az_theme.css?v2.1" type="text/css" />
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Tambahkan baris ini untuk Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        .card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            max-width: 700px;
            width: 90%;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            animation: fadeIn 1.2s ease-in-out;
            transition: box-shadow 0.3s, transform 0.3s;
        }
        /* .card:hover {
            box-shadow: 0 8px 32px 10px rgba(0,0,0,0.35);
            transform: translateY(-4px) scale(1.01);
        } */
        h1 {
            color: #1e3a8a;
            margin-bottom: 20px;
            animation: slideDown 1s ease forwards;
            font-size: 2rem;
        }
        p {
            color: #374151;
            line-height: 1.8;
            text-align: justify;
            animation: fadeIn 1.5s ease forwards;
        }
        .btn, .btn-back {
            margin-top: 20px;
            padding: 12px 24px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            animation: fadeInUp 2s ease forwards;
            width: 100%;
            max-width: 220px;
            box-sizing: border-box;
        }
        .btn:hover {
            background: #218838 !important;
            color: #fff !important;
            transform: scale(1.07);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn-back:hover {
            background: #b7bcc0 !important;
            transform: scale(1.07);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
        @keyframes slideDown {
            from {transform: translateY(-20px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        @keyframes fadeInUp {
            from {transform: translateY(20px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        .survey-top-title {
            margin: -80px auto 20px auto;
            background-color: #28a745;
            border-radius: 15px;
            display: inline-block;
            padding: 8px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .survey-top-title img {
            height: 90px;
            max-width: 100%;
            display: block;
        }
        @media (max-width: 1100px) {
        .card {
            margin-top: 50px;
            max-width: 95vw;
            padding: 24px 10vw;
        }
        }
        @media (max-width: 900px) {
        .card {
            max-width: 95vw;
            padding: 24px 10vw;
        }
        }
        @media (max-width: 600px) {
            body {
                align-items: flex-start;
                padding: 10px 0;
            }
            .card {
                padding: 18px 8px;
                border-radius: 12px;
                margin: 60px 8px 0px 8px;
            }
            h1 { font-size: 1.2rem; }
            .survey-top-title img { height: 55px; }
            .survey-top-title {
                margin: -40px auto 12px auto;
                padding: 4px 10px;
                border-radius: 8px;
            }
            .btn {
                font-size: 15px;
                padding: 10px 0;
            }
            p {
                font-size: 0.97rem;
            }
        }
        @media (max-width: 400px) {
        .card {
            margin-top: 50px;
            padding: 10px 2px;
        }
        h1 { font-size: 1rem; }
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            text-align: left;
        }


        /* ...existing code... */
        .is-invalid {
            border: 2px solid #e74c3c !important;
            background: #fff6f6;
            animation: shake 0.25s;
            position: relative;
            padding-right: 36px !important;
        }
        .invalid-feedback {
            color: #e74c3c;
            font-size: 0.97em;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0;
            animation: fadeInError 0.5s forwards;
        }
        .invalid-feedback .fa {
            color: #e74c3c;
            font-size: 1.1em;
        }
        @keyframes shake {
            0% { transform: translateX(0);}
            20% { transform: translateX(-6px);}
            40% { transform: translateX(6px);}
            60% { transform: translateX(-4px);}
            80% { transform: translateX(4px);}
            100% { transform: translateX(0);}
        }
        @keyframes fadeInError {
            to { opacity: 1; }
        }

        .kepuasan-wrapper {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            gap: 90px;
            flex-wrap: wrap; /* biar di HP bisa turun ke bawah */
        }

        .btn-kepuasan {
            background: none;
            border: none;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-kepuasan img {
            width: 80px;
            max-width: 100%;
            height: auto;
        }

        .btn-kepuasan:hover {
            transform: scale(1.05);
        }

        .nav-btn-wrapper {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap; /* supaya kalau sempit tombol bisa ke bawah */
        }

        /* Responsive */
        @media (max-width: 576px) {
            .kepuasan-wrapper {
            gap: 15px;
            }

            .btn-kepuasan img {
            width: 60px;
            }
        }
        .description-puas h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1e3a8a; /* biru elegan */
        }

        .description-tidak-puas h2 {
            font-size: 22px;
            /* font-weight: 700; */
            margin-bottom: 5px;
        }

        .description-puas p, .description-tidak-puas p {
            font-size: 16px;
            margin: 4px 0;
            line-height: 1.6;
            color: #374151;
            text-align: center;
        }

        .survey-table {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
        }
        .survey-row {
            display: grid;
            /* grid-template-columns: 1fr 1fr 1fr; */
            grid-template-columns: 160px 1fr 290px;
            gap: 10px;
            align-items: center;
        }
        .survey-col select, .survey-col input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .survey-col.label {
            font-weight: bold;
            text-align: left;
            color: #374151;
            font-size: 100%;
        }
        .survey-col.label small {
            font-weight: normal;
            font-size: 9px;
            color: #555;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .survey-row {
            grid-template-columns: 1fr;
            margin-top: 15px;
            }
        }
    </style>
</head>
<body>
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
                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">No. RM Pasien <red>*</red></label>
                <div class="col-md-5">
                    <input type="text" class="form-control format-number" id="no_rm" name="no_rm"/>
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
                <button type="button" class="btn" id="btn-next-1">Selanjutnya <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
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
                <button type="button" class="btn" id="btn-next-2" disabled>Selanjutnya <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
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
                                <input type="text" class="form-control" id="description_petugas" name="description_petugas" placeholder="Apa yang membuat anda tidak puas?"/>
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
                                <input type="text" class="form-control" id="description_fasilitas" name="description_fasilitas" placeholder="Apa yang membuat anda tidak puas?"/>
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
                                <input type="text" class="form-control" id="description_prosedur" name="description_prosedur" placeholder="Apa yang membuat anda tidak puas?"/>
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
                                <input type="text" class="form-control" id="description_waktu" name="description_waktu" placeholder="Apa yang membuat anda tidak puas?"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                <button type="button" class="btn-back" id="btn-prev-3" style="background:#6c757d;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                <button type="submit" class="btn">Kirim</button>
            </div>
        </form>
    </div>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#idruangan').select2({
            placeholder: "-- Pilih Ruang --",
            allowClear: false
        });

        $('#idlayanan_petugas').select2({
            placeholder: "-- Pilih Ruang --",
            allowClear: false
        });

        $('#idlayanan_fasilitas').select2({
            placeholder: "-- Pilih Ruang --",
            allowClear: false
        });

        $('#idlayanan_prosedur').select2({
            placeholder: "-- Pilih Ruang --",
            allowClear: false
        });

        $('#idlayanan_waktu').select2({
            placeholder: "-- Pilih Ruang --",
            allowClear: false
        });

        let formData = {};

        // Helper untuk menampilkan error pada input
        function showInputError(selector, message) {
            $(selector).addClass('is-invalid');
            if ($(selector).next('.invalid-feedback').length === 0) {
                $(selector).after('<div class="invalid-feedback"><i class="fa fa-exclamation-circle"></i> '+message+'</div>');
            }
        }
        function clearInputError(selector) {
            $(selector).removeClass('is-invalid');
            $(selector).next('.invalid-feedback').remove();
        }

        // Step 1 -> Step 2
        $('#btn-next-1').on('click', function(e) {
            e.preventDefault();
            let valid = true;
            clearInputError('#nama_pasien');
            clearInputError('#no_rm');
            clearInputError('#idruangan');

            formData.nama_pasien = $('#nama_pasien').val();
            formData.no_rm = $('#no_rm').val();
            formData.idruangan = $('#idruangan').val();

            // form validasi
            if(!formData.nama_pasien) {
                showInputError('#nama_pasien', 'Nama pasien wajib diisi');
                valid = false;
            }
            if(!formData.no_rm) {
                showInputError('#no_rm', 'No. RM wajib diisi');
                valid = false;
            }
            if(!formData.idruangan) {
                showInputError('#idruangan', 'Ruang wajib dipilih');
                $('.select2-selection').addClass('is-invalid');
                valid = false;
            } 
            else {
                $('.select2-selection').removeClass('is-invalid');
            }
            
            if(!valid) {
                // Scroll ke input pertama yang error
                $('.is-invalid:first').focus();
                return;
            }
            $('#form-step1').hide();
            $('#form-step2').show();
        });

        // Step 2: pilih puas/tidak puas
        $('.btn-kepuasan').on('click', function() {
            $('.btn-kepuasan').css('border','none');
            $(this).css('border','3px solid #28a745');
            $('#kepuasan').val($(this).data('value'));
            $('#btn-next-2').prop('disabled', false);
            $('#kepuasan').removeClass('is-invalid');
            $('#kepuasan').next('.invalid-feedback').remove();
        });

        // Step 2 -> Step 3
        $('#btn-next-2').on('click', function(e) {
            e.preventDefault();
            formData.kepuasan = $('#kepuasan').val();
            if(!formData.kepuasan) {
                // Tampilkan error di bawah pilihan
                if ($('#kepuasan').next('.invalid-feedback').length === 0) {
                    $('#kepuasan').after('<div class="invalid-feedback" style="display:block;text-align:center;">Silakan pilih tingkat kepuasan!</div>');
                }
                $('#kepuasan').addClass('is-invalid');
                return;
            }
            $('#form-step2').hide();
            $('#form-step3').show();
        });

        // Step 3 -> Submit
        $('#form-step3').on('submit', function(e) {
            e.preventDefault();
            // Ambil semua layanan yang dipilih dan keterangannya
            formData.idlayanan_petugas = [];
            formData.idlayanan_fasilitas = [];
            formData.idlayanan_prosedur = [];
            formData.idlayanan_waktu = [];

            formData.idlayanan_petugas = $('#idlayanan_petugas').val();
            formData.description_petugas = $('#description_petugas').val();

            formData.idlayanan_fasilitas = $('#idlayanan_fasilitas').val();
            formData.description_fasilitas = $('#description_fasilitas').val();

            formData.idlayanan_prosedur = $('#idlayanan_prosedur').val();
            formData.description_prosedur = $('#description_prosedur').val();

            formData.idlayanan_waktu = $('#idlayanan_waktu').val();
            formData.description_waktu = $('#description_waktu').val();

            // Contoh validasi minimal satu layanan dipilih
            if (
                (!formData.idlayanan_petugas || formData.idlayanan_petugas === '') &&
                (!formData.idlayanan_fasilitas || formData.idlayanan_fasilitas === '') &&
                (!formData.idlayanan_prosedur || formData.idlayanan_prosedur === '') &&
                (!formData.idlayanan_waktu || formData.idlayanan_waktu === '')
            ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Layanan',
                    text: 'Pilih minimal satu layanan yang ingin dinilai.'
                });
                return;
            }

            // Kirim data ke server via AJAX atau tampilkan
            // $.post('url_tujuan', formData, function(res){ ... });
            Swal.fire({
                icon: 'success',
                title: 'Terima kasih!',
                text: 'Survei Anda telah terkirim.'
            }).then(() => {
                // location.reload();
                window.location.href = "<?php echo base_url(); ?>";
            });
        });

        // Step 2 <- Step 1
        $('#btn-prev-2').on('click', function(e) {
            e.preventDefault();
            $('#form-step2').hide();
            $('#form-step1').show();
            $('#nama_pasien').val(formData.nama_pasien);
            $('#no_rm').val(formData.no_rm);
            $('#idruangan').val(formData.idruangan).trigger('change');
        });

        // Step 3 <- Step 2
        $('#btn-prev-3').on('click', function(e) {
            e.preventDefault();
            $('#form-step3').hide();
            $('#form-step2').show();
            // restore pilihan puas/tidak puas
            if(formData.kepuasan){
                $('.btn-kepuasan').each(function(){
                    if($(this).data('value') === formData.kepuasan){
                        $(this).css('border','3px solid #28a745');
                    } else {
                        $(this).css('border','none');
                    }
                });
                $('#kepuasan').val(formData.kepuasan);
                $('#btn-next-2').prop('disabled', false);
            }
        });
    });
</script>
</html>
