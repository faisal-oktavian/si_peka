<script>
    jQuery(function($) {
        var selectedRoomId = <?php echo json_encode($f_idruangan); ?>;
        var selectedRoomName = <?php echo json_encode($f_nama_ruangan); ?>;
        var roomSelect = $('#idf_ruangan');

        if (selectedRoomId && selectedRoomName) {
            roomSelect.append(new Option(selectedRoomName, selectedRoomId, true, true)).trigger('change.select2');
        }

        roomSelect.on('change', function() {
            $('#form_room_filter').submit();
        });

        $('#clear_room_filter').on('click', function() {
            roomSelect.val('');
            $('#form_room_filter').submit();
        });
    });