<style>
    h4 {
        font-weight: bold;
    }
    .heading {
        font-size: 16px;
    }
    .container-report {
        padding: 20px 10px;
    }
    .content-report {
        margin-left:10px; 
        margin-right:10px;
    }
    .report {
        padding: 20px 10px;
    }
    p {
        animation:none !important;
    }
</style>

<div class="container-fluid container-report">
    <div class="row">
        <div class="col-md-12">
            <p class="heading">Berikut adalah daftar laporan yang tersedia. Silakan pilih laporan yang ingin Anda lihat.</p>
        </div>
    </div>

    <hr>
    
    <div class="row content-report">
        <?php
            if (aznav('role_report_survei')) {
        ?>
                <div class="col-md-6 report">
                    <h4>Laporan Survei</h4>
                    <p>Menampilan data survei kepuasan pasien per bulan dan per komponen.</p>
                    <a href="<?php echo app_url().'report_survei' ?>"><button class="btn btn-primary"> Lihat Laporan</button></a>
                </div>
        <?php
            }
            // if (aznav('role_report_sisa_realisasi_anggaran')) {
        ?>
                <!-- <div class="col-md-6 report">
                </div> -->
        <?php
            // }
        ?>
    </div>
</div>