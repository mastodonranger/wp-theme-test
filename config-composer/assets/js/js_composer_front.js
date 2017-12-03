
	window.vcParallaxSkroll = !1, "function" != typeof window.vc_rowBehaviour && (window.vc_rowBehaviour = function() {
	function fullWidthRow() {
		var $elements = $('[data-vc-full-width="true"]'),
			$header = $('#header');

		$.each($elements, function(key, item) {
			var $el = $(this);
			$el.addClass("vc_hidden");
			var $el_full = $el.next(".vc_row-full-width");
			$el_full.length || ($el_full = $el.parent().next(".vc_row-full-width"));
			var el_margin_left = parseInt($el.css("margin-left"), 10),
				el_margin_right = parseInt($el.css("margin-right"), 10),
				offset = 0 - $el_full.offset().left - el_margin_left,
				width = $(window).width();

			if ( $('body').hasClass('side_header') && $header.hasClass('style_9') ) {

				if ( width < 1200 && width > 992 ) {
					offset = 0,
					width = $('.wide_layout').width();
				} else if ( width < 992 )  {

				} else {
					//offset = 0 - $('#header').outerWidth(true) - el_margin_left + 5;
					offset = 0;
					width = $('.wide_layout').width();
				}

			}

			if  ($('body').is('.rtl') ) {

				$el.css( {
					'position': 'relative',
					'left': Math.abs(offset),
					'box-sizing': 'border-box',
					'width': width
				} );
			} else {
				$el.css( {
					'position': 'relative',
					'left': offset,
					'box-sizing': 'border-box',
					'width': width
				} );
			}

			if ( ! $el.data( 'vcStretchContent' ) ) {
				var padding = (- 1 * offset);
				if ( padding < 0 ) {
					padding = 0;
				}
				var paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right;
				if ( paddingRight < 0 ) {
					paddingRight = 0;
				}
				$el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
			}

			$el.attr("data-vc-full-width-init", "true"), $el.removeClass("vc_hidden");

		}), $(document).trigger("vc-full-width-row", $elements)
	}

	function parallaxRow() {
		var vcSkrollrOptions, callSkrollInit = !1;
		return window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(), $(".vc_parallax-inner").remove(), $("[data-5p-top-bottom]").removeAttr("data-5p-top-bottom data-30p-top-bottom"), $("[data-vc-parallax]").each(function() {
			var skrollrSpeed, skrollrSize, skrollrStart, skrollrEnd, $parallaxElement, parallaxImage, youtubeId;
			callSkrollInit = !0, "on" === $(this).data("vcParallaxOFade") && $(this).children().attr("data-5p-top-bottom", "opacity:0;").attr("data-30p-top-bottom", "opacity:1;"), skrollrSize = 100 * $(this).data("vcParallax"), $parallaxElement = $("<div />").addClass("vc_parallax-inner").appendTo($(this)), $parallaxElement.height(skrollrSize + "%"), parallaxImage = $(this).data("vcParallaxImage"), youtubeId = vcExtractYoutubeId(parallaxImage), youtubeId ? insertYoutubeVideoAsBackground($parallaxElement, youtubeId) : "undefined" != typeof parallaxImage && $parallaxElement.css("background-image", "url(" + parallaxImage + ")"), skrollrSpeed = skrollrSize - 100, skrollrStart = -skrollrSpeed, skrollrEnd = 0, $parallaxElement.attr("data-bottom-top", "top: " + skrollrStart + "%;").attr("data-top-bottom", "top: " + skrollrEnd + "%;")
		});
	}

	function fullHeightRow() {
		var $element = $(".vc_row-o-full-height:first");
		if ($element.length) {
			var $window, windowHeight, offsetTop, fullHeight;
			$window = $(window),
			windowHeight = $window.height(),
			offsetTop = $element.offset().top;

			if ( $element.hasClass('vc_row-coming-soon') ) {
				offsetTop = offsetTop + ( $('#footer').outerHeight(true) - 0.5 );
			}

			if ( windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100) ) ) {
				$element.css("min-height", fullHeight + "vh");
			}

		}

		$(document).trigger("vc-full-height-row", $element)
	}

	function fixIeFlexbox() {
		var ua = window.navigator.userAgent,
			msie = ua.indexOf("MSIE ");
		(msie > 0 || navigator.userAgent.match(/Trident.*rv\:11\./)) && $(".vc_row-o-full-height").each(function() {
			"flex" === $(this).css("display") && $(this).wrap('<div class="vc_ie-flexbox-fixer"></div>')
		})
	}
	var $ = window.jQuery;
	$(window).off("resize.vcRowBehaviour").on("resize.vcRowBehaviour", fullWidthRow).on("resize.vcRowBehaviour", fullHeightRow), fullWidthRow(), fullHeightRow(), fixIeFlexbox(), vc_initVideoBackgrounds(), parallaxRow()
});

(function ($) {

	$.terminus_composer_mod = $.terminus_composer_mod || {};

	$.terminus_composer_mod.google_maps = function () {

		$('.terminus-map-wrapper').each(function( i, wrapelement ) {

			var wrap = $(wrapelement).attr('id');

			if ( typeof wrap === 'undefined' || wrap === '' )
				return false;

			var map = $(wrapelement).find('.terminus_google_map').attr('id');
			var map_override = $('#' + map).attr('data-map_override');
			var is_relative = 'true';

			$('#' + map).css( {'margin-left' : 0 } );

			var ancenstor = $('#'+wrap).parent();
			var parent = ancenstor;
			if ( map_override=='full' ) {
				ancenstor= $('body');
				is_relative = 'false';
			}

			if ( map_override=='ex-full' ) {
				ancenstor= $('html');
				is_relative = 'false';
			}

			if ( ! isNaN(map_override) ) {
				for ( var i = 0; i < map_override; i++ ) {
					if ( ancenstor.prop('tagName')!='HTML' ) {
						ancenstor = ancenstor.parent();
					} else {
						break;
					}
				}
			}

			if ( map_override == 0 || map_override == '0' )
				var w = ancenstor.width();
			else
				var w = ancenstor.outerWidth();

			var a_left = ancenstor.offset().left;
			var left = $('#' + map).offset().left;
			var calculate_left = a_left - left;

			$('#' + map).css( {'width': w } );
			if ( map_override != 0 || map_override != '0' ) {
				$('#' + map).css( {'margin-left' : calculate_left } );
			}
		});

	}

	/*	Resize															    */
	/* -------------------------------------------------------------------- */

	$(window).resize(function(){
		$.terminus_composer_mod.google_maps();
	});

	/*	Load															    */
	/* -------------------------------------------------------------------- */

	$(window).load(function () {
		$.terminus_composer_mod.google_maps();
	});

	/*	DOM READY														    */
	/* -------------------------------------------------------------------- */

	$(function () {
		$.terminus_composer_mod.google_maps();
	});

})(jQuery);