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
    .card:hover {
        box-shadow: 0 8px 32px 10px rgba(0,0,0,0.35);
        transform: translateY(-4px) scale(1.01);
    }
</style>

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
        <p>Hormat Kami,<br>
        <b>Manajemen RSUD Sumberglagah</b></p>

        <button class="btn" onclick="window.location.href='<?php echo site_url("survei"); ?>'">Mulai Survei</button>
    </div>
</div>
