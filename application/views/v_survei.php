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
                <button type="button" class="btn" id="btn-next">Selanjutnya <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </form>

        <!-- form puas / tidak puas -->
        <form id="form-step2" style="display:none;">
            <div class="form-group">
                <label>Bagaimana pelayanan kami?</label>
                <select class="form-control" name="pelayanan">
                    <option value="baik">Baik</option>
                    <option value="cukup">Cukup</option>
                    <option value="kurang">Kurang</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                <button type="button" class="btn-back" id="btn-prev" style="background:#6c757d;">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
                </button>
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

        // Simpan data sementara
        let formData = {};

        $('#btn-next').on('click', function(e) {
            e.preventDefault();
            // Ambil data input
            formData.nama_pasien = $('#nama_pasien').val();
            formData.no_rm = $('#no_rm').val();
            formData.idruangan = $('#idruangan').val();

            // Validasi sederhana
            if(!formData.nama_pasien || !formData.no_rm || !formData.idruangan) {
                alert('Mohon lengkapi semua data!');
                return;
            }

            // Sembunyikan step 1, tampilkan step 2
            $('#form-step1').hide();
            $('#form-step2').show();
        });

         // Tombol kembali ke step 1
        $('#btn-prev').on('click', function(e) {
            e.preventDefault();
            $('#form-step2').hide();
            $('#form-step1').show();
            // Kembalikan nilai input ke form-step1 jika perlu
            $('#nama_pasien').val(formData.nama_pasien);
            $('#no_rm').val(formData.no_rm);
            $('#idruangan').val(formData.idruangan).trigger('change');
        });

        // Jika ingin mengirim semua data (step1 + step2) ke server saat submit step2
        $('#form-step2').on('submit', function(e) {
            e.preventDefault();
            formData.pelayanan = $(this).find('[name="pelayanan"]').val();
            // Kirim data ke server via AJAX atau submit form
            console.log(formData);
            // Contoh AJAX:
            /*
            $.post('url_tujuan', formData, function(res){
                // handle response
            });
            */
            alert('Terima kasih atas survei Anda!');
        });
    });
</script>
</html>
