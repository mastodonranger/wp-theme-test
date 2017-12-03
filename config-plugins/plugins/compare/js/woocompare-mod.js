jQuery(document).ready(function($) {

	// open popup
	$('body').on( 'woocompare_open_popup_mod', function () {

		var compare_button = $('.product .compare.info_link', window.parent.document),
			data = {
				action: terminus_yith_woocompare_mod.action_recount
			};

		$.ajax({
			type: 'post',
			url: terminus_global_vars.ajaxurl,
			data: data,
			success: function (response) {

				if ( compare_button ) {
					compare_button.attr('data-amount', response);
				}

			}
		});

	});

	$(window).on('yith_woocompare_product_removed', function () {
		$('body').trigger('woocompare_open_popup_mod');
	});


});