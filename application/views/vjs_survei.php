<script>
    var base_url = "<?php echo base_url(''); ?>";

    // Inisialisasi Select2
    $('#idruangan').select2({
        placeholder: "-- Pilih Ruang --",
        allowClear: true
    });
    
    // Fungsi untuk inisialisasi Select2 untuk layanan
    function initLayananSelect2() {
        $('#idlayanan_petugas, #idlayanan_fasilitas, #idlayanan_prosedur, #idlayanan_waktu').select2({
            placeholder: "-- Pilih Layanan --",
            allowClear: false
        });
    }

    // Panggil saat halaman dimuat
    initLayananSelect2(); 

    let formData = {};
    let selectedLayananDescriptions = {
        petugas: {},
        fasilitas: {},
        prosedur: {},
        waktu: {}
    }; // Menyimpan deskripsi untuk setiap layanan yang dipilih

    // Helper untuk menampilkan error pada inputan
    function showInputError(selector, message) {
        $(selector).addClass('is-invalid');

        if ($(selector).next('.select2-container').length > 0) {
            $(selector).next('.select2-container').find('.select2-selection').addClass('is-invalid');
        }
        
        if ($(selector).parent().find('.invalid-feedback').length === 0) {
            $(selector).parent().append('<div class="invalid-feedback" style="display:block;"><i class="fa fa-exclamation-circle"></i> ' + message + '</div>');
        }
    }

    function clearInputError(selector) {
        $(selector).removeClass('is-invalid');
        
        if ($(selector).next('.select2-container').length > 0) {
            $(selector).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
        }
        
        $(selector).parent().find('.invalid-feedback').remove();
    }

    // Helper untuk menampilkan error pada input dinamis
    function showDynamicInputError(inputElement, message) {
        $(inputElement).addClass('is-invalid');

        if ($(inputElement).next('.invalid-feedback-dynamic').length === 0) {
            $(inputElement).after('<div class="invalid-feedback-dynamic"><i class="fa fa-exclamation-circle"></i> ' + message + '</div>');
        }
    }

    function clearDynamicInputError(inputElement) {
        $(inputElement).removeClass('is-invalid');
        $(inputElement).next('.invalid-feedback-dynamic').remove();
    }

    // Fungsi generateDescriptionInputs
    function generateDescriptionInputs(selectId, containerId, category) {
        const selectedOptions = $(selectId).find('option:selected');
        const container = $(containerId);
        
        // Reset variabel sebelum menambahkan yang baru
        container.empty();
        
        // Default jika belum set
        const kepuasan = formData.kepuasan || 'puas';
        const placeholderText = kepuasan === 'puas' ? 'Masukkan saran Anda' : 'Apa yang membuat Anda tidak puas?';
        
        // Untuk menampilkan deskripsi dari layanan yang dipilih
        if (selectedOptions.length > 0) {
            selectedOptions.each(function() {
                const id = $(this).val();
                
                const name = $(this).data('name') || 
                             $(this).attr('data-name') || 
                             $(this).text() || 
                             'Layanan Tidak Dikenal';
                             
                const descriptionInput = `
                    <div class="description-item" data-layanan-id="${id}">
                        <label for="desc_${category}_${id}">${name}:</label>
                        <input type="text" class="form-control description-input"
                               id="desc_${category}_${id}"
                               name="description_${category}[${id}]"
                               placeholder="${placeholderText}"
                               value="${selectedLayananDescriptions[category][id] || ''}" />
                    </div>
                `;
                container.append(descriptionInput);
            });
        }
    }

    // Event listener untuk perubahan pada select layanan
    const categoryConfigs = {
        'idlayanan_petugas': { category: 'petugas', container: '#description_petugas_container' },
        'idlayanan_fasilitas': { category: 'fasilitas', container: '#description_fasilitas_container' },
        'idlayanan_prosedur': { category: 'prosedur', container: '#description_prosedur_container' },
        'idlayanan_waktu': { category: 'waktu', container: '#description_waktu_container' }
    };

    // Untuk memanggil fungsi generate deskripsi layanan
    $('#idlayanan_petugas, #idlayanan_fasilitas, #idlayanan_prosedur, #idlayanan_waktu').on('change', function() {
        const selectId = '#' + $(this).attr('id'); // Misal '#idlayanan_fasilitas'
        const config = categoryConfigs[$(this).attr('id')];
        
        if (!config) {
            return;
        }

        const selectedValues = $(this).val() || [];
        
        // Simpan deskripsi yang sudah ada sebelum generate ulang
        $(config.container).find('.description-input').each(function() {
            const layananId = $(this).closest('.description-item').data('layanan-id');
            selectedLayananDescriptions[config.category][layananId] = $(this).val();
        });
        
        // Hapus deskripsi untuk layanan yang tidak lagi dipilih
        for (const id in selectedLayananDescriptions[config.category]) {
            if (!selectedValues.includes(id)) {
                delete selectedLayananDescriptions[config.category][id];
            }
        }
        
        generateDescriptionInputs(selectId, config.container, config.category);
        clearInputError(selectId);
    });

    // Event input dinamis (OK)
    $(document).on('input', '.description-input', function() {
        clearDynamicInputError(this);
        const layananId = $(this).closest('.description-item').data('layanan-id');
        const nameAttr = $(this).attr('name');
        
        if (!nameAttr) {
            return;
        }

        const category = nameAttr.split('[')[0].replace('description_', '');
        selectedLayananDescriptions[category][layananId] = $(this).val();
    });
    
    // jika inputannya sudah diisi maka pesan erornya dihapus
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
            $('#idruangan').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
        }
    });

    // OTP Email Pasien
    let resendTimeout = false;
    let surveyStartTime = new Date(); // waktu survei dimulai
    let verifOTP = false;

    $('#otp, #email').on('input', function() {
        verifOTP = false;
    });

    $('#btnSendOTP').on('click', function() {
        if (resendTimeout) {
            alert('Silakan tunggu 1 menit untuk kirim ulang OTP.');
            return;
        }

        show_loading();
        var input_email = $('#email').val();

        setTimeout(function () {
            send_otp(input_email);
        }, 1000);
    });

    function send_otp(input_email) {
        $.post(base_url + 'survei/send_otp', { 
            email: input_email 
        }, function(res) {
            let data = JSON.parse(res);
            hide_loading();

            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    // title: 'Terima kasih!',
                    text: data.message,
                    customClass: {
                        popup: 'swal2-large'
                    }
                }).then(() => {
                    // code
                });
            }
            else {
                Swal.fire({
                    icon: 'error',
                    // title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat menyimpan data.',
                    customClass: {
                        popup: 'swal2-large'
                    }
                });
            }

            if (data.status) {
                resendTimeout = true;
                setTimeout(() => resendTimeout = false, 60000); // 1 menit
            }
        });
    }

    $('#btnVerifyOTP').on('click', function() {
        show_loading();

        setTimeout(function () {
            verify_otp();
        }, 1000);
    });

    function verify_otp() {
        $.post(base_url + 'survei/verify_otp', { 
            email: $('#email').val(), 
            otp: $('#otp').val() 
        }, function(res) {
            let data = JSON.parse(res);
            hide_loading();

            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    // title: 'Terima kasih!',
                    text: data.message,
                    customClass: {
                        popup: 'swal2-large'
                    }
                }).then(() => {
                    verifOTP = true;
                });
            }
            else {
                Swal.fire({
                    icon: 'error',
                    // title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat menyimpan data.',
                    customClass: {
                        popup: 'swal2-large'
                    }
                }).then(() => {
                    verifOTP = false;
                });
            }
        });
    }
    // END OTP Email Pasien

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
        formData.email = $('#email').val();

        // form validasi
        if (!formData.nama_pasien) {
            showInputError('#nama_pasien', 'Nama pasien wajib diisi');
            valid = false;
        }

        if (!formData.no_rm) {
            showInputError('#no_rm', 'No. RM wajib diisi');
            valid = false;
        }
        // validasi no rm: wajib 8 digit angka
        if (!/^\d{8}$/.test(formData.no_rm)) {
            showInputError('#no_rm', 'No. RM wajib 8 digit angka');
            valid = false;
        }

        if (!formData.idruangan) {
            showInputError('#idruangan', 'Ruang wajib dipilih');
            $('.select2-selection').addClass('is-invalid');
            valid = false;
        } 
        else {
            $('.select2-selection').removeClass('is-invalid');
        }
        
        if (!valid) {
            $('.is-invalid:first').focus();
            return;
        }

        if (!verifOTP) {
            Swal.fire({
                icon: 'error',
                // title: 'Gagal',
                text: 'Email belum diverifikasi.',
                customClass: {
                    popup: 'swal2-large'
                }
            });

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
        if (!formData.kepuasan) {
            
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
                if (!$(this).val()) { 
                    $(this).attr("placeholder", "Masukkan saran Anda");
                }
            });
        } 
        else {
            $('.description-puas').hide();
            $('.description-tidak-puas').show();

            $('#form-step3').find("input[type=text]").each(function(ev){
                if (!$(this).val()) { 
                    $(this).attr("placeholder", "Apa yang membuat anda tidak puas?");
                }
            });
        }

        setTimeout(function () {
            initLayananSelect2(); 
        }, 100);

        generateDescriptionInputs('#idlayanan_petugas', '#description_petugas_container', 'petugas');
        generateDescriptionInputs('#idlayanan_fasilitas', '#description_fasilitas_container', 'fasilitas');
        generateDescriptionInputs('#idlayanan_prosedur', '#description_prosedur_container', 'prosedur');
        generateDescriptionInputs('#idlayanan_waktu', '#description_waktu_container', 'waktu');

        // Update placeholder pada input yang sudah ada (jika ada)
        $('.description-input').each(function() {
            if (!$(this).val()) {
                $(this).attr('placeholder', formData.kepuasan === 'puas' ? 'Masukkan saran Anda' : 'Apa yang membuat Anda tidak puas?');
            }
        });

        $('#form-step2').hide();
        $('#form-step3').show();

        // Ubah CSS card menjadi lebih lebar saat Step 3 terbuka
        $('.card').css('max-width', '850px');
        // $('.card').css('margin-top', '150px');
        // $('.card').css('margin-bottom', '80px');
        if (window.matchMedia("(max-width: 400px)").matches) {
            $('body').css('height', '130vh');
        }
    });

    // Step 3 -> Submit
    $('#form-step3').on('submit', function(e) {
        e.preventDefault();
        let valid = true;
        let firstInvalidInput = null;

        // formData.device_id = $('#device_id').val();
        // formData.device_meta = $('#device_meta').val();
        formData.start_time_survei = surveyStartTime.toISOString();

        // Reset semua error sebelumnya
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('.invalid-feedback-dynamic').remove();

        // Kumpulkan data layanan dan deskripsi
        formData.idlayanan_petugas = $('#idlayanan_petugas').val() || [];
        formData.description_petugas = {};
        $('#description_petugas_container .description-input').each(function() {
            const layananId = $(this).closest('.description-item').data('layanan-id');
            formData.description_petugas[layananId] = $(this).val();
        });

        formData.idlayanan_fasilitas = $('#idlayanan_fasilitas').val() || [];
        formData.description_fasilitas = {};
        $('#description_fasilitas_container .description-input').each(function() {
            const layananId = $(this).closest('.description-item').data('layanan-id');
            formData.description_fasilitas[layananId] = $(this).val();
        });

        formData.idlayanan_prosedur = $('#idlayanan_prosedur').val() || [];
        formData.description_prosedur = {};
        $('#description_prosedur_container .description-input').each(function() {
            const layananId = $(this).closest('.description-item').data('layanan-id');
            formData.description_prosedur[layananId] = $(this).val();
        });

        formData.idlayanan_waktu = $('#idlayanan_waktu').val() || [];
        formData.description_waktu = {};
        $('#description_waktu_container .description-input').each(function() {
            const layananId = $(this).closest('.description-item').data('layanan-id');
            formData.description_waktu[layananId] = $(this).val();
        });


        // Semua layanan wajib dipilih minimal 1
        if (!formData.idlayanan_petugas || formData.idlayanan_petugas.length === 0) {
            showInputError('#idlayanan_petugas', 'Pilih minimal 1 petugas');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_petugas');
        }

        if (!formData.idlayanan_fasilitas || formData.idlayanan_fasilitas.length === 0) {
            showInputError('#idlayanan_fasilitas', 'Pilih minimal 1 fasilitas');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_fasilitas');
        }

        if (!formData.idlayanan_prosedur || formData.idlayanan_prosedur.length === 0) {
            showInputError('#idlayanan_prosedur', 'Pilih minimal 1 prosedur layanan');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_prosedur');
        }

        if (!formData.idlayanan_waktu || formData.idlayanan_waktu.length === 0) {
            showInputError('#idlayanan_waktu', 'Pilih minimal 1 waktu layanan');
            valid = false;
        } 
        else {
            clearInputError('#idlayanan_waktu');
        }

        if (!valid) {
            return;
        }
        
        // Validasi setiap layanan yang dipilih harus mengisi deskripsi
        const validateCategory = (categoryName, selectedIds, descriptionMap, selectElementId) => {
            if (selectedIds.length > 0) {
                // Validasi select2 itu sendiri
                if (!$(selectElementId).val() || $(selectElementId).val().length === 0) {
                    showInputError(selectElementId, `Pilih minimal satu layanan ${categoryName}`);
                    if (!firstInvalidInput) {
                        firstInvalidInput = $(selectElementId);
                    }
                    valid = false;
                }

                // Validasi setiap input deskripsi
                for (const id of selectedIds) {
                    const descriptionInput = $(`#desc_${categoryName}_${id}`);
                    if (!descriptionInput.val() || descriptionInput.val().trim() === '') {
                        showDynamicInputError(descriptionInput, 'Keterangan wajib diisi');
                        if (!firstInvalidInput) {
                            firstInvalidInput = descriptionInput;
                        }
                        valid = false;
                    }
                }
            }
        };
        
        validateCategory('petugas', formData.idlayanan_petugas, formData.description_petugas, '#idlayanan_petugas');
        validateCategory('fasilitas', formData.idlayanan_fasilitas, formData.description_fasilitas, '#idlayanan_fasilitas');
        validateCategory('prosedur', formData.idlayanan_prosedur, formData.description_prosedur, '#idlayanan_prosedur');
        validateCategory('waktu', formData.idlayanan_waktu, formData.description_waktu, '#idlayanan_waktu');

        if (!valid) {
            if (firstInvalidInput) {
                $('html, body').animate({
                    scrollTop: firstInvalidInput.offset().top - 100
                }, 500);
                firstInvalidInput.focus();
            }
            return;
        }

        // Kirim data ke server via AJAX
        $.ajax({
            url: "<?php echo site_url('survei/save'); ?>",
            type: "POST",
            data: {
                nama_pasien: formData.nama_pasien,
                no_rm: formData.no_rm,
                idruangan: formData.idruangan,
                kepuasan: formData.kepuasan,
                idlayanan_petugas: formData.idlayanan_petugas,
                description_petugas: formData.description_petugas, // Ini akan menjadi objek {id: deskripsi}
                idlayanan_fasilitas: formData.idlayanan_fasilitas,
                description_fasilitas: formData.description_fasilitas,
                idlayanan_prosedur: formData.idlayanan_prosedur,
                description_prosedur: formData.description_prosedur,
                idlayanan_waktu: formData.idlayanan_waktu,
                description_waktu: formData.description_waktu,
                // device_id: formData.device_id,
                // device_meta: formData.device_meta,
                start_time_survei: formData.start_time_survei,
                email: formData.email,
            },
            dataType: "json",
            success: function(res) {
                if (res.err_code == 0) {
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
                        text: res.err_message || 'Terjadi kesalahan saat menyimpan data.',
                        customClass: {
                            popup: 'swal2-large'
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                    customClass: {
                        popup: 'swal2-large'
                    }
                });
            }
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
        
        if (formData.kepuasan) {
            $('.btn-kepuasan').each(function() {
                if ($(this).data('value') === formData.kepuasan){
                    $(this).css('border','3px solid #28a745');
                } 
                else {
                    $(this).css('border','none');
                }
            });

            $('#kepuasan').val(formData.kepuasan);
            $('#btn-next-2').prop('disabled', false);
        }

        // Ubah CSS card menjadi lebih kecil saat selain Step 3 terbuka
        $('.card').css('max-width', '700px');

        if (window.matchMedia("(max-width: 400px)").matches) {
            $('body').css('height', '100vh');
        }
    });

    function show_loading() {
        Swal.fire({
            title: 'Mohon tunggu...',
            text: 'Sedang memproses data',
            allowOutsideClick: false,
            customClass: {
                popup: 'swal2-large'
            },
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function hide_loading() {
        Swal.close();
    }

    // Selfie
    let streamRef = null;
    const video = document.getElementById('video');
    const btnStart = document.getElementById('btnStartCamera');
    const btnCapture = document.getElementById('btnCapture');
    const btnStop = document.getElementById('btnStopCamera');
    const thumb = document.getElementById('thumb');
    const fileInput = document.getElementById('selfie_file');
    const selfiePath = document.getElementById('selfie_path');
    const canvas = document.createElement('canvas');

    btnStart.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            streamRef = stream;

            // tampilkan video & tombol capture
            video.style.display = 'block';
            btnCapture.style.display = 'inline-block';
            btnStop.style.display = 'inline-block';
            btnStart.style.display = 'none';
            thumb.style.display = 'none';
        } catch (e) {
            alert('Kamera tidak dapat diakses: ' + e.message);
        }
    });

    btnStop.addEventListener('click', () => {
        if (streamRef) {
            streamRef.getTracks().forEach(t => t.stop());
            streamRef = null;
        }
        video.style.display = 'none';
        btnCapture.style.display = 'none';
        btnStop.style.display = 'none';
        btnStart.style.display = 'inline-block';
    });

    btnCapture.addEventListener('click', () => {
        let canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const vw = video.videoWidth;
        const vh = video.videoHeight;
        const size = 400;
        canvas.width = size;
        canvas.height = size;
        ctx.drawImage(video, 0, 0, size, size);

        const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
        thumb.src = dataUrl;
        thumb.style.display = 'inline-block';

        // console.log('Base64 length:', dataUrl.length);
        // console.log('Base64 prefix:', dataUrl.substring(0, 30));

        // Kirim ke server
        uploadSelfie(dataUrl);

        // Tutup kamera otomatis
        btnStop.click();
    });

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            alert('File terlalu besar (maks. 5MB)');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            thumb.src = e.target.result;
            thumb.style.display = 'inline-block';
        };
        reader.readAsDataURL(file);

        const fd = new FormData();
        fd.append('selfie_file', file);

        $.ajax({
            url: base_url + 'survei/upload_selfie',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    selfiePath.value = res.path;
                } 
                else {
                    alert('Gagal upload: ' + res.message);
                }
            }
        });
    });

    function uploadSelfie(dataUrl) {
        $.post(base_url + 'survei/upload_selfie', { selfie_data: dataUrl }, function(res) {
            try {
                const data = JSON.parse(res);
                if (data.status) {
                    selfiePath.value = data.path;
                } 
                else {
                    alert('Gagal upload: ' + data.message);
                }
            } catch (err) {
                console.error(err);
            }
        });
    }