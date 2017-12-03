(function ($, window) {

	/* ------------------------------------------------------------------ */
	/*	Framework Popup 												  */
	/* ------------------------------------------------------------------ */

	$.fn.terminus_framework_popup = function (options, callback) {

		var defaults = {
			message: "",
			showTime: 2000,
			type: 'default',
			animIn: 'mad-popup-show',
			animOut: 'mad-popup-hide',
			add_class: '',
			callfunc: ''
		}, o = $.extend({}, defaults, options);

		return this.each(function () {
			var $this = $(this);
			({
				init: function () {
					var base = this;
						base.setUp();
						base.html();
						if (o.type == 'confirm') {
							base.listeners();
						}

						if (o.type == 'default') {
							base.popup.trigger('out');
							if (typeof callback == 'function') { callback(); }
						}
				},
				setUp: function () {
					var animEndEventNames = {
						'WebkitAnimation' : 'webkitAnimationEnd',
						'OAnimation' : 'oAnimationEnd',
						'msAnimation' : 'MSAnimationEnd',
						'animation' : 'animationend'
					};
					this.animEndEventName = animEndEventNames[Modernizr.prefixed('animation')];
					this.animations = Modernizr.cssanimations;
					this.namespace	= '.mad_popup';

					this.popup = $('<div/>', {
						'class' : 'mad-popup-wrapper'
					}).addClass(o.animIn).on('out', $.proxy(function () {
						this.hide();
					}, this));
				},
				hide: function () {
					var base = this,
					showTime = (o.type == 'default') ? o.showTime : 0;
					base.popup.removeClass(o.animIn);
					setTimeout( function () {
						base.popup.addClass(o.animOut);
					}, showTime);
					var onEndAnimationFn = function () {
						base.popup.remove();
					};
					if (base.animations) {
						base.popup.on(base.animEndEventName, onEndAnimationFn);
					} else {
						onEndAnimationFn();
					}
				},
				html: function () {
					var	output = '<div class="mad-popup-content '+ o.add_class + ' ' + 'mad-type-' + o.type + '">';
					output += '<span>' + o.message + '</span>';

					if (o.type == 'confirm') {
						output += '<div class="mad-confirm-set">';
							output += '<a href="#mad-yes" class="mad-confirm-yes">Yes</a>';
							output += '<a href="#mad-no" class="mad-confirm-no">No</a>';
						output += '</div>';
					}

					output += '</div>';
					$this.append(this.popup);
					this.popup.html(output);
				},
				listeners: function () {
					var base = this,
						callfunc = o.callfunc;

					base.popup.on('click' + base.namespace, '.mad-confirm-yes', function (e) {
						e.preventDefault();
						base.hide();
						if (typeof callfunc == 'function') {
							callfunc.call(base, e);
						}
					});

					base.popup.on('click' + base.namespace, '.mad-confirm-no', function (e) {
						e.preventDefault();
						base.hide();
					});
				}
			}).init();
		});
	}

	/* ------------------------------------------------------------------ */
	/*	Framework Behavior												  */
	/* ------------------------------------------------------------------ */

	function terminus_framework_behavior (element) {
		this.element = $(element);
		this.init();
		this.listeners();
	}

	terminus_framework_behavior.prototype = {
		init: function () {

			var $element = this.element;
			if (!$element.length) return;

			this.saveButton = $('.button_save', $element);
			this.resetButton = $('.button_reset', $element);
			this.importButton = $('.button_import', $element);

			this.dataObj = {
				container: 		$element,
				slug:			$('input[name=options_page_slug]', $element).val(),
				prefix:			$('input[name=options_prefix]', $element).val(),
				ajaxurl:		$('input[name=admin_ajax_url]', $element).val(),
				actionreset:	$('input[name=reset_action]', $element).val(),
				actionsave:		$('input[name=save_action]', $element).val(),
				actionimport:	$('input[name=import_action]', $element).val(),
				noncereset  :	$('input[name=nonce-reset]', $element).val(),
				noncesave:		$('input[name=nonce-save]', $element).val(),
				nonceimport  :	$('input[name=nonce-import]', $element).val()
			};
		},
		methods: {
			resetOptions: function (param) {
				var data = param.data;
					data.container.terminus_framework_popup({
						message: terminus_framework_localize.resetText,
						type: 'confirm',
						callfunc: function () {
							var base = this;

							$.ajax({
								type: "POST",
								url: data.ajaxurl,
								data: {
									action: data.actionreset,
									_wpnonce: data.noncereset
								},
								beforeSend: function () { },
								error: function () {
									window.location.reload(true);
								},
								success: function (response) {
									if (response.match('reset')) {
										base.hide();
										window.location.reload(true);
									}
								},
								complete: function (response) { }
							});
						}
					});
				return false;
			},
			saveOptions: function (param) {
				var data = param.data,
					formElements = $('input[type="text"], input[type="number"], input[type="hidden"], input[type="checkbox"], input[type="radio"]:checked, select, textarea', data.container),
					stringData = "";

				$.each(formElements, function (id, val) {
					var element = $(val),
						name = element.attr('name'),
						value = element.val();

					if ( name != '' ) {
						if ( element.is('input:checkbox') && !element.is('input:checked') ) {
							value = '0';
						}
						stringData  += "&" + name + "=" + encodeURIComponent(value);
					}
				});

				stringData = stringData.substr(1);

				$.ajax({
					type: "POST",
					url: data.ajaxurl,
					data: {
						prefix: data.prefix,
						action: data.actionsave,
						_wpnonce: data.noncesave,
						slug: data.slug,
						data: stringData
					},
					beforeSend: function () { },
					error: function () {
						data.container.terminus_framework_popup({
							message: terminus_framework_localize.errorText,
							add_class: 'mad-message-error'
						});
					},
					success: function (response) {
						if ( response.match('save') ) {
							data.container.terminus_framework_popup({
								message: terminus_framework_localize.successText,
								add_class: 'mad-message-success'
							});
						}
					},
					complete: function () { }
				});
				return false;
			},
			importOptions: function (param) {
				var data = param.data,
					$button = $(this),
					$path = $button.data('path'),
					$parent = $button.parent('.import-wrap'),
					startLabel = $('.import-started', $parent);

				if ($button.is('.not-click')) return false;

				data.container.terminus_framework_popup({
					message: terminus_framework_localize.importText,
					type: 'confirm',
					callfunc: function (e) {

						$.ajax({
							type: "POST",
							url: ajaxurl,
							data: {
								action: data.actionimport,
								_wpnonce: data.nonceimport,
								path: $path
							},
							beforeSend: function () {
								$button.addClass('not-click');
								$parent.addClass('not-hover');
								$('.import-loading', $parent).animate({ opacity: 1 });
								startLabel.slideDown(400);
							},
							error: function () {
								window.location.reload(true);
							},
							success: function (response) {

								if (response.match('madImport')) {
									response = response.replace('madImport', '');

									data.container.terminus_framework_popup({
										message: terminus_framework_localize.importsuccessText,
										add_class: 'mad-message-success'
									}, function () {
										window.location.reload(true);
									});
								}
							},
							complete: function () {
								setTimeout(function () {
									$button.removeClass('not-click');
									$parent.removeClass('not-hover');
									$('.import-loading',  $parent).fadeOut();
									startLabel.slideUp(400);
								}, 2500);
							}
						});

					}
				});
				return false;
			}
		},
		listeners: function () {
			var base = this;
				base.saveButton.on('click',  base.dataObj, base.methods.saveOptions);
				base.resetButton.on('click', base.dataObj, base.methods.resetOptions);
				base.importButton.on('click', base.dataObj, base.methods.importOptions);
		}
	}

	/* ------------------------------------------------------------------ */
	/*	Navigation Behavior												  */
	/* ------------------------------------------------------------------ */

	function terminus_navigation_behavior(element) {
		this.element = $(element);

		this.adminLink = $('.admin-menu-link', this.$element);

		this.listeners();
		this.init();
	}

	terminus_navigation_behavior.prototype = {
		init: function() {
			var $element = this.element;

			$('.sub-tab-content', $element).first().addClass('active-content');

			var url_hash = window.location.hash.substring(1);

			this.adminLink.each(function (id, link) {
				var $link = $(link);

				if (url_hash) {
					if ($link.data('to') === url_hash) {
						$link.trigger('click');
					}
				} else {
					if (id == 0) {
						$link.addClass('active-nav');
					}
				}
			});

		},
		listeners: function() {
			$(document).on('click', '.admin-menu-link', function (e) {
				var $this = $(this),
					$to = $('#' + $this.data('to'));
				if ($to.length) {
					$this.siblings().removeClass('active-nav').end().addClass('active-nav');
					$to.siblings().removeClass('active-content').end().addClass('active-content');
				}
				e.preventDefault();
			});
		}
	}

	/* ------------------------------------------------------------------ */
	/*	Form Required													  */
	/* ------------------------------------------------------------------ */

	function terminus_form_required(element) {
		this.element = $(element);
		this.init();
		this.process();
	}

	terminus_form_required.prototype = {
		init: function () {
			this.data = {
				el: this.element,
				required : $('.mad_required', this.element).val().split(':')
			};
			this.element.css({ display: 'none' });
		},
		process: function () {

			var wrapper = this.element.siblings('div[id$=' + this.data.required[0] + ']'),
				element = $('[name$=' + this.data.required[0] + ']', wrapper);

			if ( element.is('input[type=radio]') ) {

				if ( element.filter(':checked').val() == this.data.required[1] ) {
					this.element.css({ display: 'block' });
				}

			} else {

				if ( element.val() == this.data.required[1] ) {
					this.element.css({ display: 'block' });
				}

			}

			if ( element.is('input[type=hidden]') ) {
				element = element.siblings();
			}

			if ( element.is('input[type=radio]') ) {
				element = element.siblings('img');
			}

			element.on('change.form_required click.form_required', this.data, this.change);

		},
		change: function (passed) {
			var el_check = $(this),
				data = passed.data;

			if ( el_check.is('img') ) {
				val = el_check.siblings(':input').val();
			} else if ( el_check.is(':input') ) {
				val = el_check.val();
			} else {
				val = el_check.data('value');
			}

			if ( val == data.required[1] ) {
				if ( data.el.css('display') == 'none' ) {
					data.el.slideDown(400);
				}
			} else {
				if ( data.el.css('display') == 'block' ) {
					data.el.slideUp(400);
				}
			}
		}
	}

	/* ------------------------------------------------------------------ */
	/*	TabGroups														  */
	/* ------------------------------------------------------------------ */

	function terminus_function_tab_groups (element) {
		this.element = $(element);
		this.init();
	}

	terminus_function_tab_groups.prototype = {
		init: function () {
			this.create();
			this.listener();
		},
		create: function () {
			var base = this,
				element = base.element;

			element.each(function() {
				var current = $(this),
					tabs = current.children('.mad_tab'),
					output = active = '';
				base.navContainer = $('<div class="mad-tabs-nav"></div>');

				tabs.each(function (idx) {
					var el = $(this),
						title = el.data('tab-title'),
						id = el.attr('id');
						if (idx == 0) {
							el.addClass('mad-active-tab-content');
						}
						idx == 0 ? active = 'mad-active-tab-nav' : active = '';
						output += '<a href="#' + id + '" class="mad-tab-title '+ active +'">'+ title +'</a>';
				});
				base.navContainer.html(output);
				element.prepend(base.navContainer);
			});
		},
		listener: function () {
			this.navContainer.on('click', '.mad-tab-title', function (e) {
				e.preventDefault();
				var $this = $(this),
					$to = $($this.attr('href'));

				if ($to.length) {
					$this.siblings().removeClass('mad-active-tab-nav').end().addClass('mad-active-tab-nav');
					$to.siblings().removeClass('mad-active-tab-content').end().addClass('mad-active-tab-content');
				}
			});
		}
	}

	/* ------------------------------------------------------------------ */
	/*	Image Select													  */
	/* ------------------------------------------------------------------ */

	$.terminus_field_objects = $.terminus_field_objects || {};

	$.terminus_field_objects.image_select = function() {

		$( '.mad_image_select' ).each(
			function() {
				var el = $( this );

				el.find( '.mad-image-select label img' ).click(
					function( e ) {
						var id = $( this ).closest( 'label' ).attr( 'for' );

						$( this ).parents( ".image_select:first" ).find( '.mad-image-select-selected' ).removeClass( 'mad-image-select-selected' ).find( "input[type='radio']" ).attr(
							"checked", false
						);
						$( this ).closest( 'label' ).find( 'input[type="radio"]' ).prop( 'checked' );

						el.find( 'label[for="' + id + '"]' ).addClass( 'mad-image-select-selected' ).find( "input[type='radio']" ).attr(
							"checked", true
						);

						//var bottom = el.next().offset().top;
						//
						//console.log(el.next(':visible'));
						//
						//$('.mad-admin-content').animate({
						//	scrollTop: bottom
						//}, 500);

						return false;
					}
				);

			}
		);

	};

	/* ------------------------------------------------------------------ */
	/*	Change Color Schemes											  */
	/* ------------------------------------------------------------------ */

	$.fn.terminus_change_color_schemes = function () {
		return this.each(function () {

			var $this = $(this);

			({
				init: function () { this.listener(); },
				click: function (e) {
					e.preventDefault();

					var $el = $(e.target),
						dataObj = $el.data();
						$el.siblings().removeClass('active').end().addClass('active');

					for (i in dataObj) {
						if (typeof dataObj[i] == "string" || typeof dataObj[i] == "number" || typeof dataObj[i] == "boolean") {
							var id = i.replace( /([A-Z])/g, "-$1" ).toLowerCase(), el = $('#' + id);

							if (el.length) {
								if ( el.is('input[type=text]') || el.is('select') || el.is('input[type=hidden]') ) {
									el.val(dataObj[i]).trigger('change');
								}
							}
						}
					}

				},
				listener: function () { $this.on('click', '.color-scheme-link', $.proxy(this.click, this)); }
			}.init());

		});
	};

	/* ------------------------------------------------------------------ */
	/*	Change Buttons Set												  */
	/* ------------------------------------------------------------------ */

	$.fn.terminus_change_buttons_set = function() {

		var $this = $('.buttonsset', this);

		$this.each(function () {

			var $element = $(this),
				$input_hidden = $('input[type="hidden"]', $element);

			$element.on('click', '.buttonset', function (e) {

				e.preventDefault();

				var $button = $(this),
					new_value = $button.data('value');

				if ( $button.hasClass( 'active' ) ) {
					return;
				}

				$input_hidden.val(new_value);
				$button.siblings().removeClass('active').end().addClass('active');
			});

		});

		return this;

	};

	/* ------------------------------------------------------------------ */
	/*	Change Switch Set												  */
	/* ------------------------------------------------------------------ */

	$.fn.terminus_change_switch_set = function() {

		var $this = $('.switch_set', this);

		$this.each(function () {

			var $element = $(this),
				$input_hidden = $('input[type="hidden"]', $element);


			if (!$input_hidden) { return; }

			$element.on('click', 'label', function (e) {

				e.preventDefault();

				var $button = $(this),
					new_value = $button.data('value');

				if ( $button.hasClass( 'selected' ) ) {
					return;
				}

				$input_hidden.val(new_value);
				$button.siblings().removeClass('selected').end().addClass('selected');
			});

		});

		return this;

	};

	/* ------------------------------------------------------------------ */
	/*	Footer Widgets													  */
	/* ------------------------------------------------------------------ */

	$.fn.terminus_framework_footer_widgets = function () {
		return ({
			init: function () {
				var base = this;
					base.widgetTemplate = $('#terminus-tmpl-options-hidden');
					base.listeners();
			},
			listeners: function () {
				var base = this,
					obj = $.parseJSON(base.widgetTemplate.html());

				$(".mad-control ul.options-columns").on('click', 'li', function () {
					var $this = $(this),
						val = $this.data('val'),
						container = $this.closest('.meta-set'),
						hidden = container.find('.data-widgets-hidden'),
						display = container.find('.meta-columns-set');

					console.log(obj);

					var newValue = {};
					newValue[val] = [obj[val][0]];
					hidden.data('columns', val).attr('value', JSON.stringify(newValue));

					$this.siblings('li').removeClass('active').end().addClass('active');

					display.children().removeClass('hidden');
					display.children().slice(val).addClass('hidden');

					for (i = 0; i < obj[val][0].length; i++) {
						display.find('.mod-columns:nth-child(' + (i + 1) + ')').attr("class", "mod-columns mod-grid-" + obj[val][0][i] + "");
					}
					return false;
				});

			}
		}.init());

	}

	/* ------------------------------------------------------------------ */
	/*	$.fn.extend														  */
	/* ------------------------------------------------------------------ */

	$.fn.extend({
		terminus_framework_behavior: function () {
			return this.each(function () {
				var $this = $(this),
					data = $this.data('terminus_framework_behavior');
				if (!data) {
					$this.data('terminus_framework_behavior', new terminus_framework_behavior(this));
				}
			});
		},
		terminus_navigation_behavior: function () {
			return this.each(function () {
				var $this = $(this),
					data = $this.data('terminus_navigation_behavior');
				if (!data) {
					$this.data('terminus_navigation_behavior', new terminus_navigation_behavior(this));
				}
			});
		},
		terminus_tab_groups: function () {
			return this.each(function () {
				var $this = $(this),
					data = $this.data('terminus_function_tab_groups');
				if (!data) {
					$this.data('terminus_function_tab_groups', new terminus_function_tab_groups(this));
				}
			});
		},
		terminus_form_required: function () {
			return this.each(function () {
				var $this = $(this),
					data = $this.data('terminus_form_required');
				if (!data) {
					$this.data('terminus_form_required', new terminus_form_required(this));
				}
			});
		}
	});

	/* ------------------------------------------------------------------ */
	/*	DOM READY														  */
	/* ------------------------------------------------------------------ */

	$(function () {
		$('#mad-options-page')
			.terminus_framework_behavior()
			.terminus_navigation_behavior()
			.terminus_change_buttons_set()
			.terminus_change_switch_set();

		$('[id*="_tab_container"]').terminus_tab_groups();
		$('.wp-color-picker').wpColorPicker();
		$('.color-schemes-list').terminus_change_color_schemes();

		if ($.fn.terminus_framework_footer_widgets) {
			$.fn.terminus_framework_footer_widgets();
		}

		$('.mad_required_section').terminus_form_required();

		$.terminus_field_objects.image_select();
	});

})(jQuery, window);