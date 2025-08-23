<script>
	/* max */
	window.onscroll = function() {
	    myFunction()
	};

	var offset = jQuery('.header-second').offset();
	var sticky = offset.top;

	function myFunction() {
	    console.log(sticky);
	    if (window.pageYOffset > sticky) {
	        jQuery('.header-second').addClass('sticky')
	    } else {
	        jQuery('.header-second').removeClass('sticky')
	    }
	}

	jQuery('.btn-search').on('click', function() {
		var keyword = jQuery('#search').val();
		window.location.href = app_url + "search?search="+keyword;
	});
	/* end max */

	jQuery("body").on("click", ".hidden-menu-text", function() {
		jQuery("menu ul:eq(0)").slideToggle('fast');
		jQuery("menu .hidden-menu-text i").toggleClass("fa-caret-square-o-up fa-caret-square-o-down");
	});

	jQuery('.img-btn-language').click(function() {
		var lang = jQuery(this).attr('data-id');
		jQuery.ajax({
			url: app_url+'home/change_language/'+lang,
			success:function(respond){
				location.reload();
			},
		});
	});

	var bhei = jQuery(window).height();
	var header = jQuery('.header-first').innerHeight();
	var header_second = jQuery('.header-second').innerHeight();
	var footer = jQuery('.footer').innerHeight();
	var copyright = jQuery('.copyright').innerHeight();

	var hei = bhei - header - header_second - footer - copyright + 80; 
	var hei_checkout = hei + 30;

	jQuery('.container-body').css('min-height', hei+'px');
	jQuery('.container-body-checkout').css('min-height', hei_checkout+'px');


	jQuery('body').on('click', '.btn-login-head', function() {
		jQuery('.box-login-header-wrap').toggleClass('hide');
	});

	jQuery(document).click(function(event) { 
	    if(!jQuery(event.target).closest('.btn-login-head, .box-login-header-wrap').length) {
	        jQuery('.box-login-header-wrap').addClass('hide');
	    }        
	});

	jQuery('.container-cart').hover(function() {
		jQuery('.box-login-header-wrap').addClass('hide');
	});

	jQuery('body').on('click', '.btn-login-header', function() {
		login_header();
	});

	jQuery('body').on('keydown', '#h_password', function(evt) {
		if (evt.keyCode == 13) {
			login_header();
		}
	});

	function login_header() {
		jQuery.ajax({
			url: app_url + 'auth/login_post',
			type: 'POST',
			dataType: 'JSON',
			data: {
				email: jQuery('#h_username').val(),
				password: jQuery('#h_password').val()
			},
			success: function(response) {
				if (response.err_code == 0) {
					location.href = app_url;
				}
				else {
					bootbox.alert({
						title: '',
						message: response.err_message,
						buttons: {
					        ok: {
					            label: 'Yes',
					            className: 'hide'
					        },
					    },
					});
				}
			},
			error: function(response) {}
		});
	}

	jQuery('body').on('click', '.xs-menu-list-category', function() {
		toggle_menu();
	});

	toggle_menu();
	function toggle_menu() {
		jQuery('.xs-menu-category').slideToggle('fast');
		jQuery('.caret-category').toggleClass('fa-chevron-right fa-chevron-down');
	}

	jQuery('body').on('touchstart', '.cmx-close', function() {
		jQuery('.container-menu-xs').css('background', 'none');
		jQuery('.container-menu-xs').toggle('slide', {direction: 'right'}, 600, function() {
		});
	});

	jQuery('body').on('touchstart', '.hsb-col-xs-menu', function() {
		jQuery('.container-menu-xs').toggle('slide', {direction: 'right'}, 600, function() {
			jQuery('.container-menu-xs').css('background', '#00000082');
		});
	});
	function get_autocomplete() {
	    jQuery.ajax({
	        url: app_url+'search/autocomplete',
	        type: 'POST',
	        dataType: 'JSON',
	        data: {
	            keyword: jQuery('#search').val()
	        },
	        success: function(response) {
	            jQuery('.autocomplete-list').html('');
	            jQuery(response).each(function(adata, bdata) {
	                jQuery('.autocomplete-list').append("<li><a href='"+bdata.url+"'>"+bdata.name+"</a></li>");
	            });
	            if (response.length > 0) {
	                jQuery('.box-search').show();
	            }
	            else {
	                jQuery('.box-search').hide();
	            }
	        },
	        error: function(response) {
	            console.log(response);
	        }
	    });
	}

	jQuery('#search').on('keyup', function() {
        var keyword = jQuery('#search').val();
        if (keyword.length > 0) {
            get_autocomplete();
        }
        else {
            jQuery('.box-search').hide();
        }
    });

    jQuery(document).mouseup(function (e) {
        var container = jQuery('.box-search');

        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    jQuery("#search").focus();