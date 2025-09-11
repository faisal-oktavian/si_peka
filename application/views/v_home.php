<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="<?php echo base_url().AZAPP_FRONT.'assets/logo/logo saja png.png';?>" />
    <title><?php echo az_get_config('app_name');?> - Survei</title>

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
        .card:hover {
            box-shadow: 0 8px 32px 10px rgba(0,0,0,0.35);
            transform: translateY(-4px) scale(1.01);
        }
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
        .btn {
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
            background: #218838;
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
    </style>
</head>
<body>
  <div class="card">
    <div class="survey-top-title">
        <img src="<?php echo base_url('application/assets/logo/banner_survei.png'); ?>" alt="Logo Jatim">
    </div>
    <div>
        <h1>Halo, Sobat Sehat 👋</h1>
        <p>
        Kami sangat menghargai waktu dan masukan anda. Dalam upaya kami untuk
        terus meningkatkan kualitas layanan, kami ingin meminta kesediaan anda
        untuk mengisi survei kepuasan pelanggan yang kami sediakan.
        Survei ini hanya membutuhkan waktu beberapa menit dan seluruh jawaban
        yang anda berikan <span style="font-weight:bold; color:red;">akan dijaga kerahasiaannya</span>.
        Partisipasi anda sangat berarti bagi kami, dan masukan anda akan
        membantu kami memberikan layanan yang lebih baik lagi kedepannya.
        </p>
        <p><strong>Terima kasih atas waktu dan perhatian anda.</strong></p>
        <p>Hormat Kami,<br><b>Manajemen RSUD Sumberglagah</b></p>
        <button class="btn" onclick="window.location.href='<?php echo site_url("survei"); ?>'">Mulai Survei</button>
    </div>
  </div>
</body>
</html>
