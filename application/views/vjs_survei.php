<script>
    // Inisialisasi Select2
    $('#idruangan').select2({
        placeholder: "-- Pilih Ruang --",
        allowClear: false
    });
    
    // Fungsi untuk inisialisasi Select2 untuk layanan
    function initLayananSelect2() {
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
    }

    initLayananSelect2(); // Panggil saat halaman dimuat

    let formData = {};
    let selectedLayananDescriptions = {
        petugas: {},
        fasilitas: {},
        prosedur: {},
        waktu: {}
    }; // Menyimpan deskripsi untuk setiap layanan yang dipilih

    // Helper untuk menampilkan error pada input (perbaiki untuk Select2)
    function showInputError(selector, message) {
        $(selector).addClass('is-invalid');
        // Handle Select2
        if ($(selector).next('.select2-container').length > 0) {
            $(selector).next('.select2-container').find('.select2-selection').addClass('is-invalid');
        }
        if ($(selector).parent().find('.invalid-feedback').length === 0) {
            $(selector).parent().append('<div class="invalid-feedback" style="display:block;"><i class="fa fa-exclamation-circle"></i> ' + message + '</div>');
        }
    }

    function clearInputError(selector) {
        $(selector).removeClass('is-invalid');
        // Handle Select2
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

    // Fungsi generateDescriptionInputs (DIPERBAIKI: Fallback untuk name)
    function generateDescriptionInputs(selectId, containerId, category) {
        const selectedOptions = $(selectId).find('option:selected');
        const container = $(containerId);
        container.empty(); // Kosongkan container sebelum menambahkan yang baru
        
        // Fallback jika kepuasan belum set (dari analisis sebelumnya)
        const kepuasan = formData.kepuasan || 'puas'; // Default jika belum set
        const placeholderText = kepuasan === 'puas' ? 'Masukkan saran Anda' : 'Apa yang membuat Anda tidak puas?';
        
        if (selectedOptions.length > 0) {
            selectedOptions.each(function() {
                const id = $(this).val();
                // PERBAIKAN: Gunakan fallback untuk name - prioritaskan .data(), lalu .attr(), lalu .text()
                const name = $(this).data('name') || 
                             $(this).attr('data-name') || 
                             $(this).text() || 
                             'Layanan Tidak Dikenal'; // Ultimate fallback
                             
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

    // Event listener untuk perubahan pada select layanan (UNIFIED: Satu handler untuk semua, hindari duplikat)
    // Hapus 4 event change terpisah sebelumnya, ganti dengan ini
    const categoryConfigs = {
        'idlayanan_petugas': { category: 'petugas', container: '#description_petugas_container' },
        'idlayanan_fasilitas': { category: 'fasilitas', container: '#description_fasilitas_container' },
        'idlayanan_prosedur': { category: 'prosedur', container: '#description_prosedur_container' },
        'idlayanan_waktu': { category: 'waktu', container: '#description_waktu_container' }
    };

    // Event change untuk select (satu event handler untuk semua, hindari duplikat)
    $('#idlayanan_petugas, #idlayanan_fasilitas, #idlayanan_prosedur, #idlayanan_waktu').on('change', function() {
        const selectId = '#' + $(this).attr('id'); // Misal '#idlayanan_fasilitas'
        const config = categoryConfigs[$(this).attr('id')];
        if (!config) return;
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
        clearInputError(selectId); // Clear error for select2 itself
    });

    // Event input dinamis (OK)
    $(document).on('input', '.description-input', function() {
        clearDynamicInputError(this);
        const layananId = $(this).closest('.description-item').data('layanan-id');
        const nameAttr = $(this).attr('name');
        if (!nameAttr) return;
        const category = nameAttr.split('[')[0].replace('description_', '');
        selectedLayananDescriptions[category][layananId] = $(this).val();
    });
    

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
            // $('.select2-selection').removeClass('is-invalid');
            $('#idruangan').next('.select2-container').find('.select2-selection').removeClass('is-invalid'); // Spesifik
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
            initLayananSelect2(); // Panggil saat halaman dimuat
        }, 100);

        
        // PERBAIKAN: Generate input dinamis SEKARANG untuk semua kategori (berdasarkan selection saat ini, jika ada)
        // Ini fix jika ada pre-selected value
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

        // TAMBAHAN: Ubah CSS card menjadi lebih lebar saat Step 3 terbuka
        $('.card').css('max-width', '850px');
    });

    // Step 3 -> Submit (MODIFIKASI)
    $('#form-step3').on('submit', function(e) {
        e.preventDefault();
        let valid = true;
        let firstInvalidInput = null;

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

        if (!valid) {
            return;
        }

        
        // Validasi: Setiap layanan yang dipilih harus memiliki deskripsi
        const validateCategory = (categoryName, selectedIds, descriptionMap, selectElementId) => {
            if (selectedIds.length > 0) {
                // Validasi select2 itu sendiri
                if (!$(selectElementId).val() || $(selectElementId).val().length === 0) {
                    showInputError(selectElementId, `Pilih minimal satu layanan ${categoryName}`);
                    if (!firstInvalidInput) firstInvalidInput = $(selectElementId);
                    valid = false;
                }
                // Validasi setiap input deskripsi
                for (const id of selectedIds) {
                    const descriptionInput = $(`#desc_${categoryName}_${id}`);
                    if (!descriptionInput.val() || descriptionInput.val().trim() === '') {
                        showDynamicInputError(descriptionInput, 'Keterangan wajib diisi');
                        if (!firstInvalidInput) firstInvalidInput = descriptionInput;
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
                // Scroll ke elemen yang error
                $('html, body').animate({
                    scrollTop: firstInvalidInput.offset().top - 100 // Sesuaikan offset jika perlu
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

    // // Step 3 -> Submit
    // $('#form-step3').on('submit', function(e) {
    //     e.preventDefault();
    //     // Ambil semua layanan yang dipilih dan keterangannya
    //     formData.idlayanan_petugas = [];
    //     formData.idlayanan_fasilitas = [];
    //     formData.idlayanan_prosedur = [];
    //     formData.idlayanan_waktu = [];

    //     formData.idlayanan_petugas = $('#idlayanan_petugas').val();
    //     formData.description_petugas = $('#description_petugas').val();

    //     formData.idlayanan_fasilitas = $('#idlayanan_fasilitas').val();
    //     formData.description_fasilitas = $('#description_fasilitas').val();

    //     formData.idlayanan_prosedur = $('#idlayanan_prosedur').val();
    //     formData.description_prosedur = $('#description_prosedur').val();

    //     formData.idlayanan_waktu = $('#idlayanan_waktu').val();
    //     formData.description_waktu = $('#description_waktu').val();

    //     let valid = true;

    //     // Contoh validasi minimal satu layanan dipilih
    //     // if (
    //     //     (!formData.idlayanan_petugas || formData.idlayanan_petugas === '') &&
    //     //     (!formData.idlayanan_fasilitas || formData.idlayanan_fasilitas === '') &&
    //     //     (!formData.idlayanan_prosedur || formData.idlayanan_prosedur === '') &&
    //     //     (!formData.idlayanan_waktu || formData.idlayanan_waktu === '')
    //     // ) {
    //     //     Swal.fire({
    //     //         icon: 'warning',
    //     //         title: 'Pilih Layanan',
    //     //         text: 'Pilih minimal satu layanan yang ingin dinilai.',
    //     //         customClass: {
    //     //             popup: 'swal2-large'
    //     //         }
    //     //     });
    //     //     return;
    //     // }

    //     // Semua layanan wajib dipilih minimal 1
    //     if (
    //         !formData.idlayanan_petugas || formData.idlayanan_petugas.length === 0
    //     ) {
    //         showInputError('#idlayanan_petugas', 'Pilih minimal 1 petugas');
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#idlayanan_petugas');
    //     }

    //     if (
    //         !formData.idlayanan_fasilitas || formData.idlayanan_fasilitas.length === 0
    //     ) {
    //         showInputError('#idlayanan_fasilitas', 'Pilih minimal 1 fasilitas');
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#idlayanan_fasilitas');
    //     }

    //     if (
    //         !formData.idlayanan_prosedur || formData.idlayanan_prosedur.length === 0
    //     ) {
    //         showInputError('#idlayanan_prosedur', 'Pilih minimal 1 prosedur layanan');
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#idlayanan_prosedur');
    //     }

    //     if (
    //         !formData.idlayanan_waktu || formData.idlayanan_waktu.length === 0
    //     ) {
    //         showInputError('#idlayanan_waktu', 'Pilih minimal 1 waktu layanan');
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#idlayanan_waktu');
    //     }

    //     // // Validasi jika layanan dipilih maka keterangannya wajib diisi
    //     // if (formData.idlayanan_petugas && (!formData.description_petugas || formData.description_petugas.trim() === '')) {
    //     //     showInputError('#description_petugas', 'Keterangan wajib diisi jika layanan dipilih');
    //     //     $('#description_petugas').focus();
    //     //     return;
    //     // } 
    //     // else {
    //     //     clearInputError('#description_petugas');
    //     // }
        
    //     // if (formData.idlayanan_fasilitas && (!formData.description_fasilitas || formData.description_fasilitas.trim() === '')) {
    //     //     showInputError('#description_fasilitas', 'Keterangan wajib diisi jika layanan dipilih');
    //     //     $('#description_fasilitas').focus();
    //     //     return;
    //     // } 
    //     // else {
    //     //     clearInputError('#description_fasilitas');
    //     // }
        
    //     // if (formData.idlayanan_prosedur && (!formData.description_prosedur || formData.description_prosedur.trim() === '')) {
    //     //     showInputError('#description_prosedur', 'Keterangan wajib diisi jika layanan dipilih');
    //     //     $('#description_prosedur').focus();
    //     //     return;
    //     // } 
    //     // else {
    //     //     clearInputError('#description_prosedur');
    //     // }
        
    //     // if (formData.idlayanan_waktu && (!formData.description_waktu || formData.description_waktu.trim() === '')) {
    //     //     showInputError('#description_waktu', 'Keterangan wajib diisi jika layanan dipilih');
    //     //     $('#description_waktu').focus();
    //     //     return;
    //     // } 
    //     // else {
    //     //     clearInputError('#description_waktu');
    //     // }

    //     // Validasi jika layanan dipilih maka keterangannya wajib diisi
    //     if (formData.idlayanan_petugas && formData.idlayanan_petugas.length > 0 && (!formData.description_petugas || formData.description_petugas.trim() === '')) {
    //         showInputError('#description_petugas', 'Keterangan wajib diisi jika layanan dipilih');
    //         $('#description_petugas').focus();
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#description_petugas');
    //     }
        
    //     if (formData.idlayanan_fasilitas && formData.idlayanan_fasilitas.length > 0 && (!formData.description_fasilitas || formData.description_fasilitas.trim() === '')) {
    //         showInputError('#description_fasilitas', 'Keterangan wajib diisi jika layanan dipilih');
    //         $('#description_fasilitas').focus();
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#description_fasilitas');
    //     }

    //     if (formData.idlayanan_prosedur && formData.idlayanan_prosedur.length > 0 && (!formData.description_prosedur || formData.description_prosedur.trim() === '')) {
    //         showInputError('#description_prosedur', 'Keterangan wajib diisi jika layanan dipilih');
    //         $('#description_prosedur').focus();
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#description_prosedur');
    //     }

    //     if (formData.idlayanan_waktu && formData.idlayanan_waktu.length > 0 && (!formData.description_waktu || formData.description_waktu.trim() === '')) {
    //         showInputError('#description_waktu', 'Keterangan wajib diisi jika layanan dipilih');
    //         $('#description_waktu').focus();
    //         valid = false;
    //     } 
    //     else {
    //         clearInputError('#description_waktu');
    //     }

    //     if (!valid) {
    //         return;
    //     }

    //     // Kirim data ke server via AJAX atau tampilkan
    //     // $.post('url_tujuan', formData, function(res){ ... });
    //     $.ajax({
    //         url: "<?php echo site_url('survei/save'); ?>",
    //         type: "POST",
    //         data: {
    //             nama_pasien: formData.nama_pasien,
    //             no_rm: formData.no_rm,
    //             idruangan: formData.idruangan,
    //             kepuasan: formData.kepuasan,
    //             idlayanan_petugas: formData.idlayanan_petugas,
    //             description_petugas: formData.description_petugas,
    //             idlayanan_fasilitas: formData.idlayanan_fasilitas,
    //             description_fasilitas: formData.description_fasilitas,
    //             idlayanan_prosedur: formData.idlayanan_prosedur,
    //             description_prosedur: formData.description_prosedur,
    //             idlayanan_waktu: formData.idlayanan_waktu,
    //             description_waktu: formData.description_waktu
    //         },
    //         dataType: "json",
    //         success: function(res) {
    //             if(res.err_code == 0) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Terima kasih!',
    //                     text: res.err_message,
    //                     customClass: {
    //                         popup: 'swal2-large'
    //                     }
    //                 }).then(() => {
    //                     window.location.href = "<?php echo base_url(); ?>";
    //                 });
    //             } 
    //             else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Gagal',
    //                     text: res.message || 'Terjadi kesalahan saat menyimpan data.',
    //                     customClass: {
    //                         popup: 'swal2-large'
    //                     }
    //                 });
    //             }
    //         },
    //         error: function() {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Gagal',
    //                 text: 'Terjadi kesalahan saat menyimpan data.',
    //                 customClass: {
    //                     popup: 'swal2-large'
    //                 }
    //             });
    //         }
    //     });
    // });

    // Step 2 <- Step 1
    $('#btn-prev-2').on('click', function(e) {
        e.preventDefault();
        $('#form-step2').hide();
        $('#form-step1').show();
        $('#nama_pasien').val(formData.nama_pasien);
        $('#no_rm').val(formData.no_rm);
        $('#idruangan').val(formData.idruangan).trigger('change');
    });

    // Step 3 <- Step 2 (MODIFIKASI)
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

        // TAMBAHAN: Ubah CSS card menjadi lebih lebar saat Step 3 terbuka
        $('.card').css('max-width', '700px');
    });

    // // Step 3 <- Step 2
    // $('#btn-prev-3').on('click', function(e) {
    //     e.preventDefault();
    //     $('#form-step3').hide();
    //     $('#form-step2').show();
    //     // restore pilihan puas/tidak puas
    //     if(formData.kepuasan){
    //         $('.btn-kepuasan').each(function(){
    //             if($(this).data('value') === formData.kepuasan){
    //                 $(this).css('border','3px solid #28a745');
    //             } else {
    //                 $(this).css('border','none');
    //             }
    //         });
    //         $('#kepuasan').val(formData.kepuasan);
    //         $('#btn-next-2').prop('disabled', false);
    //     }
    // });