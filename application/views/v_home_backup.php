<?php 
    $this->load->helper('az_config');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="<?php echo base_url().AZAPP_FRONT.'assets/logo/logo saja png.png';?>" />
        <title><?php echo az_get_config('app_name');?> - Survei</title>
        <!-- Google Fonts Rubik -->
        <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/az-core/az-core.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/az-core/az-core-left-theme.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url().AZAPP;?>assets/plugins/az_theme/az_theme.css?v2.1" type="text/css" />
        <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <style type="text/css">
            * {
                font-family: 'Rubik', sans-serif;
                font-size: 16px;
            }
            body {
                margin: 0;
                min-height: 100vh;
                background-image: url('<?php echo base_url("application/assets/bg_login.png"); ?>');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(255, 255, 255, 0.4);
                pointer-events: none;
                z-index: 0;
            }
            .survei-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .survei-container-content {
                box-shadow: 0 5px 24px 6px rgba(166, 166, 166, 0.18);
                background-color: rgba(255, 255, 255, 0.92);
                /* background-color: rgba(67, 119, 123, 1); */
                border-radius: 18px;
                padding: 2.5rem 2.5rem 2rem 2.5rem;
                margin: 2rem 0;
                max-width: 670px;
                width: 100%;
                position: relative;
                z-index: 1;
                transition: box-shadow 0.3s, transform 0.3s;
                animation: fadeInUp 1s;
            }
            .survei-container-content:hover {
                box-shadow: 0 8px 32px 10px rgba(166, 166, 166, 0.25);
                transform: translateY(-4px) scale(1.01);
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(40px);}
                to { opacity: 1; transform: translateY(0);}
            }
            .survei-logo {
                display: block;
                margin: 0 auto 1.5rem auto;
                max-width: 90px;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
            h3 {
                font-weight: 700;
                color: #2b3a55;
                margin-bottom: 1rem;
                text-align: center;
            }
            p {
                color: #333;
                margin-bottom: 0.5rem;
                text-align: justify;
            }
            .survei-footer {
                margin-top: 2rem;
                font-size: 15px;
                color: #666;
                text-align: right;
            }
            @media (max-width: 768px) {
                .survei-container-content {
                    padding: 1.2rem 0.8rem 1rem 0.8rem;
                    max-width: 98vw;
                }
                h3 {
                    font-size: 1.3rem;
                }
            }
            @media (max-width: 480px) {
                .survei-container-content {
                    padding: 0.7rem 0.3rem 0.7rem 0.3rem;
                }
                .survei-logo {
                    max-width: 60px;
                }
            }

            .btn-survei {
                margin-top: 25px;
                margin-bottom: 20px;
            }
            .survei-btn-cta:hover, .survei-btn-cta:focus {
                background: #1a6ed8;
                color: #fff;
                transform: translateY(-2px) scale(1.03);
                box-shadow: 0 4px 16px rgba(26,110,216,0.13);
            }
        </style>
    </head>
    <body>
        <div class="survei-container w-100">
            <div class="survei-container-content">
                <!-- <img src="<?php echo base_url().AZAPP_FRONT.'assets/logo/logo saja png.png';?>" alt="Logo RSUD" class="survei-logo"> -->
                <div class="text-center mb-3">
                    <img src="<?php echo base_url('application/assets/logo/banner_survei.png'); ?>" alt="Logo Jatim" style="height:90px;">
                </div>
                <h3>Halo, Sobat Sehat</h3>
                <p>
                    Kami sangat menghargai waktu dan masukan anda. Dalam upaya kami untuk terus meningkatkan kualitas layanan, kami ingin meminta kesediaan anda untuk mengisi survei kepuasan pelanggan yang kami sediakan. Survei ini hanya membutuhkan waktu beberapa menit dan seluruh jawaban yang anda berikan <span style="font-weight:bold; color:red;">akan dijaga kerahasiaannya</span>. Partisipasi anda sangat berarti bagi kami, dan masukan anda akan membantu kami memberikan layanan yang lebih baik lagi kedepannya.<br>
                    Terima kasih atas waktu dan perhatian anda.
                </p>
                <div class="survei-footer">
                    Hormat Kami,<br>
                    <b>Manajemen RSUD Sumberglagah</b>
                </div>
                <div class="text-center mt-4 btn-survei">
                    <a href="<?php echo base_url('survei'); ?>" class="btn btn-success btn-lg px-5 shadow-sm survei-btn-cta" style="border-radius: 30px; font-weight: 200; letter-spacing: 1px; transition: background 0.2s;">
                        Mulai Survei
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    setTimeout(function(){
        jQuery(".login-error-message").hide("slow")
    }, 5000);
</script>