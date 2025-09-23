<style>
	.centered {
		/* width: ; */
		float: none;
		margin: 20px auto;
	}

	.dropdown-menu {
		padding: 10px;
	}

	.setting-btn {
		background-color: #f2f2f2;
		padding: 5px 10px;
		border-radius: 6px;
		border: 2px #87ceeb solid;
		display: flex;
		align-items: center;
		/* justify-content: space-between; */
	}

	.setting-btn span {
		margin-left: 10px;
		color: gray;
	}

	/* .dropdown-child a:hover {
		color: #232323 !important;
		background: #f3f3f3 !important;
	} */

	.chart-box {
		border-bottom: 5px dashed #f5f5f5;
	}

	.title-chart {
		font-weight: bold;
		padding-bottom: 5px;
	}

	.h3-not-found {
		text-align: center;
		/* height: fit-content; */
		margin: 100px;
		color: #dadada;
		display: flex;
		/* flex-wrap: ; */
		justify-content: center;
	}

	.dropdown-label {
		margin-right: 10px;
	}

	/* table tr{
		margin-bottom: 2px;
	} */
	.progress {
        width: 100%;
        background-color: #f3f3f3;
        border-radius: 5px;
        overflow: hidden;
    }
    .progress-bar {
        height: 20px;
        background-color: #4caf50;
        text-align: center;
        color: white;
    }
    .card{
        width: 100% !important;
    }
    h1 {
        color: #000 !important;
        font-weight: bold !important;
    }
    hr {
        border: 1px solid #d0cfcf !important;
        margin: 0px !important;
        animation: slideDown 1s ease forwards;
    }
    .separate {
        margin-top: 50px;
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
	if (aznav('role_table')) {
?>		
        <h1>Diagram Kepuasan Komponen</h1>
        <hr>
        
		<!-- Grafik puas & tidak puas -->
		<div class="row" style="margin-top:15px;">
            <div class="col-md-6 col-xs-12" style="margin:auto;">
				<div class="card shadow" style="border-radius:16px; border:1px solid #e0e0e0; padding:24px 18px 18px 18px; background:#fff;">
					<div class="d-flex align-items-center" style="margin-bottom:18px;">
						<i class="fa fa-pie-chart" style="font-size:26px;color:#4caf50;margin-right:10px;"></i>
						<span class="title-chart" style="font-size:20px;">Grafik Puas</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6" style="display:flex;align-items:center;justify-content:center;">
							<canvas id="piePuasChart" width="180" height="180"></canvas>
						</div>
						<div class="col-xs-12 col-md-6" style="display:flex;flex-direction:column;justify-content:center;">
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#2196f3;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Petugas</div>
									<div id="label-petugas-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#4caf50;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Fasilitas</div>
									<div id="label-fasilitas-puas" style="font-size:15px;"></div>
								</div>
							</div>
                            <div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#ff9800;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Prosedur</div>
									<div id="label-prosedur-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#f44336;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Waktu</div>
									<div id="label-waktu-puas" style="font-size:15px;"></div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
            <div class="col-md-6 col-xs-12" style="margin:auto;">
				<div class="card shadow" style="border-radius:16px; border:1px solid #e0e0e0; padding:24px 18px 18px 18px; background:#fff;">
					<div class="d-flex align-items-center" style="margin-bottom:18px;">
						<i class="fa fa-pie-chart" style="font-size:26px;color:#4caf50;margin-right:10px;"></i>
						<span class="title-chart" style="font-size:20px;">Grafik Tidak Puas</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6" style="display:flex;align-items:center;justify-content:center;">
							<canvas id="pieTidakPuasChart" width="180" height="180"></canvas>
						</div>
						<div class="col-xs-12 col-md-6" style="display:flex;flex-direction:column;justify-content:center;">
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#4F81BD;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Petugas</div>
									<div id="label-petugas-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#F79646;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Fasilitas</div>
									<div id="label-fasilitas-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
                            <div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#A6A6A6;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Prosedur</div>
									<div id="label-prosedur-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#FFC000;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Waktu</div>
									<div id="label-waktu-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
        </div>

        <!-- Ambil data dari controller -->
        <?php
            $respon_petugas_puas = isset($respon_puas->row()->puas_petugas) ? $respon_puas->row()->puas_petugas : 0;
            $respon_fasilitas_puas = isset($respon_puas->row()->puas_fasilitas) ? $respon_puas->row()->puas_fasilitas : 0;
            $respon_prosedur_puas = isset($respon_puas->row()->puas_prosedur) ? $respon_puas->row()->puas_prosedur : 0;
            $respon_waktu_puas = isset($respon_puas->row()->puas_waktu) ? $respon_puas->row()->puas_waktu : 0;

            $respon_petugas_tidak_puas = isset($respon_tidak_puas->row()->tidak_puas_petugas) ? $respon_tidak_puas->row()->tidak_puas_petugas : 0;
            $respon_fasilitas_tidak_puas = isset($respon_tidak_puas->row()->tidak_puas_fasilitas) ? $respon_tidak_puas->row()->tidak_puas_fasilitas : 0;
            $respon_prosedur_tidak_puas = isset($respon_tidak_puas->row()->tidak_puas_prosedur) ? $respon_tidak_puas->row()->tidak_puas_prosedur : 0;
            $respon_waktu_tidak_puas = isset($respon_tidak_puas->row()->tidak_puas_waktu) ? $respon_tidak_puas->row()->tidak_puas_waktu : 0;
        ?>

        <!-- Fungsi untuk memformat angka -->
        <script>
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' Responden';
            }
        </script>

        <!-- Grafik Puas -->
        <script>			
            var petugas_puas = <?php echo $respon_petugas_puas; ?>;
			var fasilitas_puas = <?php echo $respon_fasilitas_puas; ?>;
			var prosedur_puas = <?php echo $respon_prosedur_puas; ?>;
			var waktu_puas = <?php echo $respon_waktu_puas; ?>;

			var total_puas = petugas_puas + fasilitas_puas + prosedur_puas + waktu_puas;

			var persen_petugas_puas = total_puas ? Math.round(petugas_puas / total_puas * 100) : 0;
			var persen_fasilitas_puas = total_puas ? Math.round(fasilitas_puas / total_puas * 100) : 0;
			var persen_prosedur_puas = total_puas ? Math.round(prosedur_puas / total_puas * 100) : 0;
			var persen_waktu_puas = total_puas ? Math.round(waktu_puas / total_puas * 100) : 0;

			document.getElementById('label-petugas-puas').innerText = persen_petugas_puas + '% (' + formatRupiah(petugas_puas) + ')';
			document.getElementById('label-fasilitas-puas').innerText = persen_fasilitas_puas + '% (' + formatRupiah(fasilitas_puas) + ')';
			document.getElementById('label-prosedur-puas').innerText = persen_prosedur_puas + '% (' + formatRupiah(prosedur_puas) + ')';
			document.getElementById('label-waktu-puas').innerText = persen_waktu_puas + '% (' + formatRupiah(waktu_puas) + ')';

			var ctx = document.getElementById('piePuasChart').getContext('2d');
			var piePuasChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: [
						'Petugas',
						'Fasilitas',
						'Prosedur',
						'Waktu'
					],
					datasets: [{
						data: [
							petugas_puas,
							fasilitas_puas,
							prosedur_puas,
							waktu_puas
						],
						backgroundColor: [
							'#2196f3',
							'#4caf50',
							'#ff9800',
							'#f44336'
						],
						borderWidth: 2,
						borderColor: '#fff',
						hoverOffset: 8
					}]
				},
				options: {
					cutout: '65%',
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							callbacks: {
								label: function(context) {
									var label = context.label || '';
									var value = context.raw || 0;
									var percent = total_puas ? Math.round(value / total_puas * 100) : 0;
									return label + ': ' + percent + '% (' + formatRupiah(value) + ')';
								}
							}
						}
					}
				}
			});
		</script>

        <!-- Grafik Tidak Puas -->
        <script>			
            var petugas_tidak_puas = <?php echo $respon_petugas_tidak_puas; ?>;
			var fasilitas_tidak_puas = <?php echo $respon_fasilitas_tidak_puas; ?>;
			var prosedur_tidak_puas = <?php echo $respon_prosedur_tidak_puas; ?>;
			var waktu_tidak_puas = <?php echo $respon_waktu_tidak_puas; ?>;

			var total_tidak_puas = petugas_tidak_puas + fasilitas_tidak_puas + prosedur_tidak_puas + waktu_tidak_puas;

			var persen_petugas_tidak_puas = total_tidak_puas ? Math.round(petugas_tidak_puas / total_tidak_puas * 100) : 0;
			var persen_fasilitas_tidak_puas = total_tidak_puas ? Math.round(fasilitas_tidak_puas / total_tidak_puas * 100) : 0;
			var persen_prosedur_tidak_puas = total_tidak_puas ? Math.round(prosedur_tidak_puas / total_tidak_puas * 100) : 0;
			var persen_waktu_tidak_puas = total_tidak_puas ? Math.round(waktu_tidak_puas / total_tidak_puas * 100) : 0;

			document.getElementById('label-petugas-tidak-puas').innerText = persen_petugas_tidak_puas + '% (' + formatRupiah(petugas_tidak_puas) + ')';
			document.getElementById('label-fasilitas-tidak-puas').innerText = persen_fasilitas_tidak_puas + '% (' + formatRupiah(fasilitas_tidak_puas) + ')';
			document.getElementById('label-prosedur-tidak-puas').innerText = persen_prosedur_tidak_puas + '% (' + formatRupiah(prosedur_tidak_puas) + ')';
			document.getElementById('label-waktu-tidak-puas').innerText = persen_waktu_tidak_puas + '% (' + formatRupiah(waktu_tidak_puas) + ')';

			var ctx = document.getElementById('pieTidakPuasChart').getContext('2d');
			var pieTidakPuasChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: [
						'Petugas',
						'Fasilitas',
						'Prosedur',
						'Waktu'
					],
					datasets: [{
						data: [
							petugas_tidak_puas,
							fasilitas_tidak_puas,
							prosedur_tidak_puas,
							waktu_tidak_puas
						],
						backgroundColor: [
							'#4F81BD',
							'#F79646',
							'#A6A6A6',
							'#FFC000'
						],
						borderWidth: 2,
						borderColor: '#fff',
						hoverOffset: 8
					}]
				},
				options: {
					cutout: '65%',
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							callbacks: {
								label: function(context) {
									var label = context.label || '';
									var value = context.raw || 0;
									var percent = total_tidak_puas ? Math.round(value / total_tidak_puas * 100) : 0;
									return label + ': ' + percent + '% (' + formatRupiah(value) + ')';
								}
							}
						}
					}
				}
			});
		</script>

        <div class="separate"></div>

        <h1>Diagram Kepuasan per Komponen</h1>
        <hr>
        
        <!-- <div class="row" style="margin-top:30px;">
            <div class="col-md-12 col-xs-12">
                <div class="card shadow" 
                    style="border-radius:16px; border:1px solid #e0e0e0; 
                            padding:24px 18px 18px 18px; background:#fff; 
                            max-width: 800px; width:100%;">
                    <div class="row">
                        <div class="col-xs-12 d-flex justify-content-center align-items-center">
                            <canvas id="perKomponen" style="max-width: 100%; height:120px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
		<div class="row" style="margin-top:15px;">
            <div class="col-md-6 col-xs-12" style="margin:auto;">
				<div class="card shadow" style="border-radius:16px; border:1px solid #e0e0e0; padding:24px 18px 18px 18px; background:#fff;">
					<div class="d-flex align-items-center" style="margin-bottom:18px;">
						<i class="fa fa-pie-chart" style="font-size:26px;color:#4caf50;margin-right:10px;"></i>
						<span class="title-chart" style="font-size:20px;">Petugas</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6" style="display:flex;align-items:center;justify-content:center;">
							<canvas id="piePetugasChart" width="180" height="180"></canvas>
						</div>
						<div class="col-xs-12 col-md-6" style="display:flex;flex-direction:column;justify-content:center;">
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#2196f3;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Puas</div>
									<div id="label-per-petugas-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#f44336;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Tidak Puas</div>
									<div id="label-per-petugas-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
            <div class="col-md-6 col-xs-12" style="margin:auto;">
				<div class="card shadow" style="border-radius:16px; border:1px solid #e0e0e0; padding:24px 18px 18px 18px; background:#fff;">
					<div class="d-flex align-items-center" style="margin-bottom:18px;">
						<i class="fa fa-pie-chart" style="font-size:26px;color:#4caf50;margin-right:10px;"></i>
						<span class="title-chart" style="font-size:20px;">Fasilitas</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6" style="display:flex;align-items:center;justify-content:center;">
							<canvas id="pieFasilitasChart" width="180" height="180"></canvas>
						</div>
						<div class="col-xs-12 col-md-6" style="display:flex;flex-direction:column;justify-content:center;">
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#2196f3;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Puas</div>
									<div id="label-per-fasilitas-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#f44336;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Tidak Puas</div>
									<div id="label-per-fasilitas-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
        </div>
		<div class="row" style="margin-top:15px;">
            <div class="col-md-6 col-xs-12" style="margin:auto;">
				<div class="card shadow" style="border-radius:16px; border:1px solid #e0e0e0; padding:24px 18px 18px 18px; background:#fff;">
					<div class="d-flex align-items-center" style="margin-bottom:18px;">
						<i class="fa fa-pie-chart" style="font-size:26px;color:#4caf50;margin-right:10px;"></i>
						<span class="title-chart" style="font-size:20px;">Prosedur</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6" style="display:flex;align-items:center;justify-content:center;">
							<canvas id="pieProsedurChart" width="180" height="180"></canvas>
						</div>
						<div class="col-xs-12 col-md-6" style="display:flex;flex-direction:column;justify-content:center;">
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#2196f3;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Puas</div>
									<div id="label-per-prosedur-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#f44336;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Tidak Puas</div>
									<div id="label-per-prosedur-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
            <div class="col-md-6 col-xs-12" style="margin:auto;">
				<div class="card shadow" style="border-radius:16px; border:1px solid #e0e0e0; padding:24px 18px 18px 18px; background:#fff;">
					<div class="d-flex align-items-center" style="margin-bottom:18px;">
						<i class="fa fa-pie-chart" style="font-size:26px;color:#4caf50;margin-right:10px;"></i>
						<span class="title-chart" style="font-size:20px;">Waktu</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6" style="display:flex;align-items:center;justify-content:center;">
							<canvas id="pieWaktuChart" width="180" height="180"></canvas>
						</div>
						<div class="col-xs-12 col-md-6" style="display:flex;flex-direction:column;justify-content:center;">
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#2196f3;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Puas</div>
									<div id="label-per-waktu-puas" style="font-size:15px;"></div>
								</div>
							</div>
							<div class="mb-3" style="background:#f6f6f6;border-radius:8px;padding:12px 14px;margin-bottom:10px;display:flex;align-items:center;">
								<span style="display:inline-block;width:18px;height:18px;background:#f44336;margin-right:10px;border-radius:4px;"></span>
								<div>
									<div style="font-weight:600; text-align:left;">Tidak Puas</div>
									<div id="label-per-waktu-tidak-puas" style="font-size:15px;"></div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
        </div>

		<!-- Ambil data dari controller -->
        <?php
            $per_petugas_puas = isset($petugas_puas->row()->total_data) ? $petugas_puas->row()->total_data : 0;
            $per_petugas_tidak_puas = isset($petugas_tidak_puas->row()->total_data) ? $petugas_tidak_puas->row()->total_data : 0;
            
			$per_fasilitas_puas = isset($fasilitas_puas->row()->total_data) ? $fasilitas_puas->row()->total_data : 0;
            $per_fasilitas_tidak_puas = isset($fasilitas_tidak_puas->row()->total_data) ? $fasilitas_tidak_puas->row()->total_data : 0;
            
			$per_prosedur_puas = isset($prosedur_puas->row()->total_data) ? $prosedur_puas->row()->total_data : 0;
            $per_prosedur_tidak_puas = isset($prosedur_tidak_puas->row()->total_data) ? $prosedur_tidak_puas->row()->total_data : 0;
            
			$per_waktu_puas = isset($waktu_puas->row()->total_data) ? $waktu_puas->row()->total_data : 0;
            $per_waktu_tidak_puas = isset($waktu_tidak_puas->row()->total_data) ? $waktu_tidak_puas->row()->total_data : 0;
        ?>

        <!-- Grafik perKomponen -->
		<script>
			// Petugas 
            var per_petugas_puas = <?php echo $per_petugas_puas; ?>;
            var per_petugas_tidak_puas = <?php echo $per_petugas_tidak_puas; ?>;

			var total_petugas = per_petugas_puas + per_petugas_tidak_puas;
			var persen_per_petugas_puas = total_petugas ? Math.round(per_petugas_puas / total_petugas * 100) : 0;
			var persen_per_petugas_tidak_puas = total_petugas ? Math.round(per_petugas_tidak_puas / total_petugas * 100) : 0;

			document.getElementById('label-per-petugas-puas').innerText = persen_per_petugas_puas + '% (' + formatRupiah(per_petugas_puas) + ')';
			document.getElementById('label-per-petugas-tidak-puas').innerText = persen_per_petugas_tidak_puas + '% (' + formatRupiah(per_petugas_tidak_puas) + ')';

			var ctx = document.getElementById('piePetugasChart').getContext('2d');
			var piePetugasChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: [
						'Puas',
						'Tidak Puas',
					],
					datasets: [{
						data: [
							per_petugas_puas,
							per_petugas_tidak_puas
						],
						backgroundColor: [
							'#2196f3',
							'#f44336'
						],
						borderWidth: 2,
						borderColor: '#fff',
						hoverOffset: 8
					}]
				},
				options: {
					cutout: '65%',
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							callbacks: {
								label: function(context) {
									var label = context.label || '';
									var value = context.raw || 0;
									var percent = total_petugas ? Math.round(value / total_petugas * 100) : 0;
									return label + ': ' + percent + '% (' + formatRupiah(value) + ')';
								}
							}
						}
					}
				}
			});

			// Fasilitas
			var per_fasilitas_puas = <?php echo $per_fasilitas_puas; ?>;
			var per_fasilitas_tidak_puas = <?php echo $per_fasilitas_tidak_puas; ?>;

			var total_fasilitas = per_fasilitas_puas + per_fasilitas_tidak_puas;
			var persen_per_fasilitas_puas = total_fasilitas ? Math.round(per_fasilitas_puas / total_fasilitas * 100) : 0;
			var persen_per_fasilitas_tidak_puas = total_fasilitas ? Math.round(per_fasilitas_tidak_puas / total_fasilitas * 100) : 0;

			document.getElementById('label-per-fasilitas-puas').innerText = persen_per_fasilitas_puas + '% (' + formatRupiah(per_fasilitas_puas) + ')';
			document.getElementById('label-per-fasilitas-tidak-puas').innerText = persen_per_fasilitas_tidak_puas + '% (' + formatRupiah(per_fasilitas_tidak_puas) + ')';

			var ctx = document.getElementById('pieFasilitasChart').getContext('2d');
			var pieFasilitasChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: [
						'Puas',
						'Tidak Puas',
					],
					datasets: [{
						data: [
							per_fasilitas_puas,
							per_fasilitas_tidak_puas
						],
						backgroundColor: [
							'#2196f3',
							'#f44336'
						],
						borderWidth: 2,
						borderColor: '#fff',
						hoverOffset: 8
					}]
				},
				options: {
					cutout: '65%',
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							callbacks: {
								label: function(context) {
									var label = context.label || '';
									var value = context.raw || 0;
									var percent = total_fasilitas ? Math.round(value / total_fasilitas * 100) : 0;
									return label + ': ' + percent + '% (' + formatRupiah(value) + ')';
								}
							}
						}
					}
				}
			});

			// Prosedur
			var per_prosedur_puas = <?php echo $per_prosedur_puas; ?>;
			var per_prosedur_tidak_puas = <?php echo $per_prosedur_tidak_puas; ?>;

			var total_prosedur = per_prosedur_puas + per_prosedur_tidak_puas;
			var persen_per_prosedur_puas = total_prosedur ? Math.round(per_prosedur_puas / total_prosedur * 100) : 0;
			var persen_per_prosedur_tidak_puas = total_prosedur ? Math.round(per_prosedur_tidak_puas / total_prosedur * 100) : 0;
			
			document.getElementById('label-per-prosedur-puas').innerText = persen_per_prosedur_puas + '% (' + formatRupiah(per_prosedur_puas) + ')';
			document.getElementById('label-per-prosedur-tidak-puas').innerText = persen_per_prosedur_tidak_puas + '% (' + formatRupiah(per_prosedur_tidak_puas) + ')';

			var ctx = document.getElementById('pieProsedurChart').getContext('2d');
			var pieProsedurChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: [
						'Puas',
						'Tidak Puas',
					],
					datasets: [{
						data: [
							per_prosedur_puas,
							per_prosedur_tidak_puas
						],
						backgroundColor: [
							'#2196f3',
							'#f44336'
						],
						borderWidth: 2,
						borderColor: '#fff',
						hoverOffset: 8
					}]
				},
				options: {
					cutout: '65%',
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							callbacks: {
								label: function(context) {
									var label = context.label || '';
									var value = context.raw || 0;
									var percent = total_prosedur ? Math.round(value / total_prosedur * 100) : 0;
									return label + ': ' + percent + '% (' + formatRupiah(value) + ')';
								}
							}
						}
					}
				}
			});

			// Waktu
			var per_waktu_puas = <?php echo $per_waktu_puas; ?>;
			var per_waktu_tidak_puas = <?php echo $per_waktu_tidak_puas; ?>;

			var total_waktu = per_waktu_puas + per_waktu_tidak_puas;
			var persen_per_waktu_puas = total_waktu ? Math.round(per_waktu_puas / total_waktu * 100) : 0;
			var persen_per_waktu_tidak_puas = total_waktu ? Math.round(per_waktu_tidak_puas / total_waktu * 100) : 0;

			document.getElementById('label-per-waktu-puas').innerText = persen_per_waktu_puas + '% (' + formatRupiah(per_waktu_puas) + ')';
			document.getElementById('label-per-waktu-tidak-puas').innerText = persen_per_waktu_tidak_puas + '% (' + formatRupiah(per_waktu_tidak_puas) + ')';

			var ctx = document.getElementById('pieWaktuChart').getContext('2d');
			var pieWaktuChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: [
						'Puas',
						'Tidak Puas',
					],
					datasets: [{
						data: [
							per_waktu_puas,
							per_waktu_tidak_puas
						],
						backgroundColor: [
							'#2196f3',
							'#f44336'
						],
						borderWidth: 2,
						borderColor: '#fff',
						hoverOffset: 8
					}]
				},
				options: {
					cutout: '65%',
					plugins: {
						legend: {
							display: false
						},
						tooltip: {
							callbacks: {
								label: function(context) {
									var label = context.label || '';
									var value = context.raw || 0;
									var percent = total_waktu ? Math.round(value / total_waktu * 100) : 0;
									return label + ': ' + percent + '% (' + formatRupiah(value) + ')';
								}
							}
						}
					}
				}
			});
			
		</script>
		<!-- <script>
			var komponenLabels = [
				'Petugas', 'Fasilitas', 'Prosedur', 'Waktu'
			];

			var ctx2 = document.getElementById("perKomponen").getContext('2d');
			var perKomponen = new Chart(ctx2, {
				type: 'bar',
				data: {
					labels: komponenLabels,
					datasets: [
						{
							label: 'Puas',
							backgroundColor: 'rgba(54, 163, 235, 0.87)',
							data: <?= json_encode($arr_puas) ?>
						},
						{
							label: 'Tidak Puas',
                            backgroundColor: 'rgba(220, 0, 48, 0.85)',
							data: <?= json_encode($arr_tidak_puas) ?>
						}
					]
				},
				options: {
					responsive: true,
					plugins: {
						tooltip: {
							mode: 'index',
							intersect: false
						},
						legend: {
							position: 'bottom'
						}
					},
					interaction: {
						mode: 'nearest',
						axis: 'x',
						intersect: false
					},
					scales: {
						x: {
							title: {
								display: true,
								text: 'Komponen'
							},
							ticks: {
								font: {
									weight: 'bold'
								}
							}
						},
						y: {
							title: {
								display: true,
								text: 'Persentase (%)'
							},
							beginAtZero: true,
							ticks: {
								callback: function(value) {
									return new Intl.NumberFormat().format(value);
								}
							}
						}
					}
				}
			});

		</script> -->

        <div class="separate"></div>

        <h1>Diagram Kepuasan per Komponen (Unit)</h1>
        <hr>

        <div class="row" style="margin-top:30px;">
            <div class="col-md-6 mb-4">
                <div class="card card-custom">
                    <div class="card-header text-center">
                        <h4 style="font-weight: bold;">Petugas</h4>
                    </div>
                    <hr>
                    <div class="card-body p-3" style="margin-top: 30px;">
                        <div class="row">
                            <!-- Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #2196f3; color: #fff;">
                                        <tr>
                                            <th colspan="2">Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($petugas_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-success"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tidak Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #f44336; color: #fff;">
                                        <tr>
                                            <th colspan="2">Tidak Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($petugas_tidak_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-danger"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card card-custom">
                    <div class="card-header text-center">
                        <h4 style="font-weight: bold;">Fasilitas</h4>
                    </div>
                    <hr>
                    <div class="card-body p-3" style="margin-top: 30px;">
                        <div class="row">
                            <!-- Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #2196f3; color: #fff;">
                                        <tr>
                                            <th colspan="2">Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($fasilitas_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-success"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tidak Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #f44336; color: #fff;">
                                        <tr>
                                            <th colspan="2">Tidak Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($fasilitas_tidak_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-danger"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:30px;">
            <div class="col-md-6 mb-4">
                <div class="card card-custom">
                    <div class="card-header text-center">
                        <h4 style="font-weight: bold;">Prosedur</h4>
                    </div>
                    <hr>
                    <div class="card-body p-3" style="margin-top: 30px;">
                        <div class="row">
                            <!-- Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #2196f3; color: #fff;">
                                        <tr>
                                            <th colspan="2">Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($prosedur_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-success"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tidak Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #f44336; color: #fff;">
                                        <tr>
                                            <th colspan="2">Tidak Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($prosedur_tidak_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-danger"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card card-custom">
                    <div class="card-header text-center">
                        <h4 style="font-weight: bold;">Waktu</h4>
                    </div>
                    <hr>
                    <div class="card-body p-3" style="margin-top: 30px;">
                        <div class="row">
                            <!-- Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #2196f3; color: #fff;">
                                        <tr>
                                            <th colspan="2">Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($waktu_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-success"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tidak Puas -->
                            <div class="col-md-6">
                                <table class="table table-striped table-hover text-center">
                                    <thead style="background-color: #f44336; color: #fff;">
                                        <tr>
                                            <th colspan="2">Tidak Puas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($waktu_tidak_puas_5->result() as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $value->nama_layanan; ?></td>
                                                    <td><span class="badge bg-danger"><?php echo $value->jumlah; ?></span></td>
                                                </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="margin-bottom: 30px;"></div>
<?php
	} 
?>