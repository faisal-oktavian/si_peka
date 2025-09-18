<script>
    jQuery('body').on('click', '.btn-detail-responden', function(){
		var id = jQuery(this).attr('data_id');

		jQuery.ajax({
			url : app_url + 'responden/detail_data?id='+id,
			method : 'get',
			dataType : 'json',
			success : function(res) {
				if (res.success) {
					show_modal('detail-responden');
					jQuery('.container-responden').html(res.view);
				}
				else{
					bootbox.alert(res.message);
				}
			}
		})
	});