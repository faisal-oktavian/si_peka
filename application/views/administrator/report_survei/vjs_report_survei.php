<script>
    jQuery('body').on('click', '.btn-filter-survei', function() {
		var date1 = jQuery('#date1').val();
		var date2 = jQuery('#date2').val();
		var no_rm = jQuery('#vf_no_rm').val();
		var nama_pasien = jQuery('#vf_nama_pasien').val();
		var idruangan = jQuery('#idf_ruangan').val();
		var kepuasan = jQuery('#vf_kepuasan').val();

        if (idruangan == '' || idruangan == null) {
            idruangan = '';
        }

		location.href = app_url + 'report_survei/?date1=' + date1 + '&date2=' + date2 + '&no_rm=' + no_rm + '&nama_pasien=' + nama_pasien + '&idruangan=' + idruangan + '&kepuasan=' + kepuasan;
	});


    // ketika urlnya sudah ada get maka set filternya
	var date1 = "<?php echo $f_date1 ;?>";
	var date2 = "<?php echo $f_date2 ;?>";
	var no_rm = "<?php echo $f_no_rm ;?>";
	var nama_pasien = "<?php echo $f_nama_pasien ;?>";
	var idruangan = "<?php echo $f_idruangan ;?>";
	var nama_ruangan = "<?php echo $f_nama_ruangan ;?>";
	var kepuasan = "<?php echo $f_kepuasan ;?>";

	if (date1 != "") {
		jQuery('#date1').val(date1);
	}
	if (date2 != "") {
		jQuery('#date2').val(date2);
	}
    if (no_rm != "") {
		jQuery('#vf_no_rm').val(no_rm);
	}
    if (nama_pasien != "") {
		jQuery('#vf_nama_pasien').val(nama_pasien);
	}
    if (idruangan != "" && idruangan != null) {
        jQuery("#idf_ruangan").append(new Option(nama_ruangan, idruangan, true, true)).trigger("change.select2");
	}
    if (kepuasan != "") {
		jQuery('#vf_kepuasan').val(kepuasan);
	}