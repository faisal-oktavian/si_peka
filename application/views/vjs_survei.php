<script>
    $('#idruangan').select2({
        placeholder: "-- Pilih Ruang --",
        allowClear: false
    });
    
    $('#idlayanan_petugas').select2({
        placeholder: "-- Pilih Layanan --",
        allowClear: false
    });
    $('#idlayanan_fasilitas').select2({
        placeholder: "-- Pilih Layanan --",
        allowClear: false
    });
    $('#idlayanan_prosedur').select2({
        placeholder: "-- Pilih Layanan --",
        allowClear: false
    });
    $('#idlayanan_waktu').select2({
        placeholder: "-- Pilih Layanan --",
        allowClear: false
    });

    let formData = {};

    // Helper untuk menampilkan error pada input
    function showInputError(selector, message) {
        $(selector).addClass('is-invalid');
        // Hapus pesan error sebelumnya
        if ($(selector).parent().find('.invalid-feedback').length === 0) {
            $(selector).parent().append('<div class="invalid-feedback" style="display:block;"><i class="fa fa-exclamation-circle"></i> ' + message + '</div>');
        }
    }
    function clearInputError(selector) {
        $(selector).removeClass('is-invalid');
        $(selector).parent().find('.invalid-feedback').remove();
    }

    $('#nama_pasien').on('input', function() {
        if ($(this).val().trim() !== '') {
            clearInputError('#nama_pasien');
        }
    });

    $('#no_rm').on('input', function() {
        if ($(this).val().trim() !== '') {
            clearInputError('#no_rm');
        }
    });

    $('#idruangan').on('change', function() {
        if ($(this).val() !== '') {
            clearInputError('#idruangan');
            $('.select2-selection').removeClass('is-invalid');
        }
    });

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
        // validasi no rm: wajib 8 digit angka
        if(!/^\d{8}$/.test(formData.no_rm)) {
            showInputError('#no_rm', 'No. RM wajib 8 digit angka');
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

        if (formData.kepuasan == 'puas') {
            $('.description-puas').show();
            $('.description-tidak-puas').hide();

            $('#form-step3').find("input[type=text]").each(function(ev){
                if(!$(this).val()) { 
                    $(this).attr("placeholder", "Masukkan saran Anda");
                }
            });
        } 
        else {
            $('.description-puas').hide();
            $('.description-tidak-puas').show();

            $('#form-step3').find("input[type=text]").each(function(ev){
                if(!$(this).val()) { 
                    $(this).attr("placeholder", "Apa yang membuat anda tidak puas?");
                }
            });
        }

        setTimeout(function () {
            console.log('sada');
            $('#idlayanan_petugas').select2({
                placeholder: "-- Pilih Layanan --",
                allowClear: false
            });
            $('#idlayanan_fasilitas').select2({
                placeholder: "-- Pilih Layanan --",
                allowClear: false
            });
            $('#idlayanan_prosedur').select2({
                placeholder: "-- Pilih Layanan --",
                allowClear: false
            });
            $('#idlayanan_waktu').select2({
                placeholder: "-- Pilih Layanan --",
                allowClear: false
            });
        }, 100);


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

        let valid = true;

        // Contoh validasi minimal satu layanan dipilih
        // if (
        //     (!formData.idlayanan_petugas || formData.idlayanan_petugas === '') &&
        //     (!formData.idlayanan_fasilitas || formData.idlayanan_fasilitas === '') &&
        //     (!formData.idlayanan_prosedur || formData.idlayanan_prosedur === '') &&
        //     (!formData.idlayanan_waktu || formData.idlayanan_waktu === '')
        // ) {
        //     Swal.fire({
        //         icon: 'warning',
        //         title: 'Pilih Layanan',
        //         text: 'Pilih minimal satu layanan yang ingin dinilai.',
        //         customClass: {
        //             popup: 'swal2-large'
        //         }
        //     });
        //     return;
        // }

        // Semua layanan wajib dipilih minimal 1
        if (
            !formData.idlayanan_petugas || formData.idlayanan_petugas.length === 0
        ) {
            showInputError('#idlayanan_petugas', 'Pilih minimal 1 petugas');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_petugas');
        }

        if (
            !formData.idlayanan_fasilitas || formData.idlayanan_fasilitas.length === 0
        ) {
            showInputError('#idlayanan_fasilitas', 'Pilih minimal 1 fasilitas');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_fasilitas');
        }

        if (
            !formData.idlayanan_prosedur || formData.idlayanan_prosedur.length === 0
        ) {
            showInputError('#idlayanan_prosedur', 'Pilih minimal 1 prosedur layanan');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_prosedur');
        }

        if (
            !formData.idlayanan_waktu || formData.idlayanan_waktu.length === 0
        ) {
            showInputError('#idlayanan_waktu', 'Pilih minimal 1 waktu layanan');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_waktu');
        }

        // // Validasi jika layanan dipilih maka keterangannya wajib diisi
        // if (formData.idlayanan_petugas && (!formData.description_petugas || formData.description_petugas.trim() === '')) {
        //     showInputError('#description_petugas', 'Keterangan wajib diisi jika layanan dipilih');
        //     $('#description_petugas').focus();
        //     return;
        // } 
        // else {
        //     clearInputError('#description_petugas');
        // }
        
        // if (formData.idlayanan_fasilitas && (!formData.description_fasilitas || formData.description_fasilitas.trim() === '')) {
        //     showInputError('#description_fasilitas', 'Keterangan wajib diisi jika layanan dipilih');
        //     $('#description_fasilitas').focus();
        //     return;
        // } 
        // else {
        //     clearInputError('#description_fasilitas');
        // }
        
        // if (formData.idlayanan_prosedur && (!formData.description_prosedur || formData.description_prosedur.trim() === '')) {
        //     showInputError('#description_prosedur', 'Keterangan wajib diisi jika layanan dipilih');
        //     $('#description_prosedur').focus();
        //     return;
        // } 
        // else {
        //     clearInputError('#description_prosedur');
        // }
        
        // if (formData.idlayanan_waktu && (!formData.description_waktu || formData.description_waktu.trim() === '')) {
        //     showInputError('#description_waktu', 'Keterangan wajib diisi jika layanan dipilih');
        //     $('#description_waktu').focus();
        //     return;
        // } 
        // else {
        //     clearInputError('#description_waktu');
        // }

        // Validasi jika layanan dipilih maka keterangannya wajib diisi
        if (formData.idlayanan_petugas && formData.idlayanan_petugas.length > 0 && (!formData.description_petugas || formData.description_petugas.trim() === '')) {
            showInputError('#description_petugas', 'Keterangan wajib diisi jika layanan dipilih');
            $('#description_petugas').focus();
            valid = false;
        } 
        else {
            clearInputError('#description_petugas');
        }
        
        if (formData.idlayanan_fasilitas && formData.idlayanan_fasilitas.length > 0 && (!formData.description_fasilitas || formData.description_fasilitas.trim() === '')) {
            showInputError('#description_fasilitas', 'Keterangan wajib diisi jika layanan dipilih');
            $('#description_fasilitas').focus();
            valid = false;
        } 
        else {
            clearInputError('#description_fasilitas');
        }

        if (formData.idlayanan_prosedur && formData.idlayanan_prosedur.length > 0 && (!formData.description_prosedur || formData.description_prosedur.trim() === '')) {
            showInputError('#description_prosedur', 'Keterangan wajib diisi jika layanan dipilih');
            $('#description_prosedur').focus();
            valid = false;
        } 
        else {
            clearInputError('#description_prosedur');
        }

        if (formData.idlayanan_waktu && formData.idlayanan_waktu.length > 0 && (!formData.description_waktu || formData.description_waktu.trim() === '')) {
            showInputError('#description_waktu', 'Keterangan wajib diisi jika layanan dipilih');
            $('#description_waktu').focus();
            valid = false;
        } 
        else {
            clearInputError('#description_waktu');
        }

        if (!valid) {
            return;
        }

        // Kirim data ke server via AJAX atau tampilkan
        // $.post('url_tujuan', formData, function(res){ ... });
        $.ajax({
            url: "<?php echo site_url('survei/save'); ?>",
            type: "POST",
            data: {
                nama_pasien: formData.nama_pasien,
                no_rm: formData.no_rm,
                idruangan: formData.idruangan,
                kepuasan: formData.kepuasan,
                idlayanan_petugas: formData.idlayanan_petugas,
                description_petugas: formData.description_petugas,
                idlayanan_fasilitas: formData.idlayanan_fasilitas,
                description_fasilitas: formData.description_fasilitas,
                idlayanan_prosedur: formData.idlayanan_prosedur,
                description_prosedur: formData.description_prosedur,
                idlayanan_waktu: formData.idlayanan_waktu,
                description_waktu: formData.description_waktu
            },
            dataType: "json",
            success: function(res) {
                if(res.err_code == 0) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terima kasih!',
                        text: res.err_message,
                        customClass: {
                            popup: 'swal2-large'
                        }
                    }).then(() => {
                        window.location.href = "<?php echo base_url(); ?>";
                    });
                } 
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Terjadi kesalahan saat menyimpan data.',
                        customClass: {
                            popup: 'swal2-large'
                        }
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    customClass: {
                        popup: 'swal2-large'
                    }
                });
            }
        });
    });

    $('#description_petugas').on('input', function() {
        if ($(this).val().trim() !== '') {
            clearInputError('#description_petugas');
        }
    });

    $('#description_fasilitas').on('input', function() {
        if ($(this).val().trim() !== '') {
            clearInputError('#description_fasilitas');
        }
    });

    $('#description_prosedur').on('change', function() {
        if ($(this).val() !== '') {
            clearInputError('#description_prosedur');
            $('.select2-selection').removeClass('is-invalid');
        }
    });

    $('#description_waktu').on('change', function() {
        if ($(this).val() !== '') {
            clearInputError('#description_waktu');
            $('.select2-selection').removeClass('is-invalid');
        }
    });

    // Hapus pesan error jika select berubah dan ada value
    $('#idlayanan_petugas').on('change', function() {
        if ($(this).val() && $(this).val().length > 0) {
            clearInputError('#idlayanan_petugas');
        }
    });

    $('#idlayanan_fasilitas').on('change', function() {
        if ($(this).val() && $(this).val().length > 0) {
            clearInputError('#idlayanan_fasilitas');
        }
    });
    
    $('#idlayanan_prosedur').on('change', function() {
        if ($(this).val() && $(this).val().length > 0) {
            clearInputError('#idlayanan_prosedur');
        }
    });
    
    $('#idlayanan_waktu').on('change', function() {
        if ($(this).val() && $(this).val().length > 0) {
            clearInputError('#idlayanan_waktu');
        }
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