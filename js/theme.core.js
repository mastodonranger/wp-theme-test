 ;(function($) {

	"use strict";

	$.terminus_core = $.terminus_core || {};

	$.terminus_core_helpers = {
		owlNav : function (owl) {

			 setTimeout(function(){
				 var settings = owl.data('owlCarousel').settings;
				 if ( settings.autoplay ) return;

				 var prev = owl.find('.nav_prev'),
					 next = owl.find('.nav_next');

				 if (owl.find('.owl-item').first().hasClass('active')) prev.addClass('gt-disabled');
				 else prev.removeClass('gt-disabled');

				 if (owl.find('.owl-item').last().hasClass('active')) next.addClass('gt-disabled');
				 else next.removeClass('gt-disabled');

			 }, 100);
		 }
	}

	$.terminus_core = {

		// constants
		ISTOUCH: Modernizr.touchevents,
		EVENT: $.terminus_core.ISTOUCH ? 'touchstart' : 'click',
		ANIMATIONEND : "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
		TRANSITIONEND : "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
		TRANSITIONSUPPORTED : Modernizr.csstransitions,
		ISRTL: terminus_global_vars.rtl,

		// initialize after DOM Ready
		DOMReady: function(){
			
			var base = this;

			base.refresh_elements();
			base.extendJquery();
			base.navInit.init(base);
			base.verticalNavigation.init();
			base.components.tabs();
			base.body.terminus_lightbox();
			base.pageWrap.terminus_hover_effect();
			base.components.progressBarsAnimation();
			base.components.sideMenu();
			base.helpers.fancyboxValidate();
			base.components.backToTopBtn();
			base.components.dribbbleFeed();

			base.events.openModalSearch();
			base.events.openModalShare();
			base.events.closeBtn();
			base.events.dropdown();

			base.events.moveScroll();
			$(window).on('woof_ajax_done', function() { base.events.moveScroll(); });

			if ( $.terminus_core.ISTOUCH ) {
				base.helpers.productBoxesTouch();
				base.helpers.entriesTouch();
			}

		},

		// initialize after window Load
		windowLoad: function(){
			var base = this;
			base.components.counters();
			base.components.preloader(base.helpers.isIE() ? 7000 : 0);
			base.components.zoomOutTitle();
			base.components.gradientEffectTitle();
			base.components.uncoveringPageTitle();
			//base.helpers.responsiveOverlayBox();
			base.components.scrollSidebar.init(base);
			base.components.productRating();
			base.components.pieCharts(true);

			if ( terminus_global_vars.sticky_navigation > 0 ) {
				base.stickyHeader.init(base);
			}

			base.components.onePageNavigation.init();
			base.components.slideshowCarousel();
			base.components.folioCarousel();
			base.components.clientCarousel();
			base.components.testimonialCarousel();
			base.components.blogCarousel();
			base.components.galleryCarousel();

			base.animatedContent();
			base.components.isotope.init();
			//base.helpers.fillTheEmptyPlace.init(base);
		},

		extendJquery: function(){

			$.fn.terminus_images_loaded = function () {

				var $imgs = this.find('img[src!=""]');

				if ( !$imgs.length ) {return $.Deferred().resolve().promise();}

				var dfds = [];

				$imgs.each(function(){
					var dfd = $.Deferred();
					dfds.push(dfd);
					var img = new Image();
					img.onload = function(){dfd.resolve();}
					img.onerror = function(){dfd.resolve();}
					img.src = this.src;
				});

				return $.when.apply($,dfds);

			}

		},

		elements: {
			'body' : 'body',
			'#theme-wrapper' : 'wrapper',
			'.page_wrap' : 'pageWrap',
			'.sticky_part' : 'sticky',
			'#wpadminbar' : 'adminbar',
			'#header' : 'header',
			'#footer' : 'footer',
			'#mobile-advanced': 'navMobile',
			'.nav_wrap, .vertical_navigation': 'navMain'
		},
		$: function (selector) { return $(selector); },
		refresh_elements: function() {
			for (var key in this.elements) {
				this[this.elements[key]] = this.$(key);
			}
		},

		components: {

			dribbbleFeed: function(collection){

				var dribbble = collection ? collection : $('.dribbble_feed');

				if ( !dribbble.length ) return;

				dribbble.each(function() {

					var $this = $(this),
						access_token = $this.data('access-token'),
						shots = $this.data('shots'),
						rel = $this.data('dribbble-gallery'),
						per_page = $this.data('per-page');

					if ( !access_token ) return;

					$.jribbble.setToken(access_token);

					$.jribbble.shots(shots, {
						'per_page': per_page || 4,
						'timeframe': 'month',
						'sort': 'views'
					}).then(function(res) {
						var html = [];

						res.forEach(function(shot) {
							html.push('<li class="shots--shot">');
							html.push('<a class="fancybox_dribbble" rel="' + rel + '" href="' + shot.images.hidpi + '" target="_blank">');
							html.push('<img width="100" height="100" src="' + shot.images.normal + '">');
							html.push('</a></li>');
						});

						dribbble.html(html.join('')).find('.fancybox_dribbble').fancybox();
					});

				});

			},

			backToTopBtn: function(){

				var config = {
					offset: 350,
					transitionIn:  parseInt($.terminus_core.ISRTL) ? 'bounceInLeft' : 'bounceInRight',
					transitionOut: parseInt($.terminus_core.ISRTL) ? 'bounceOutLeft' : 'bounceOutRight'
					}, $body = $('body');

				var btn = $('<button></button>', {
					'class': 'back_to_top btn icon_only rd-grey hidden',
					'html': '<i class="icon-angle-up"></i>'
				}).appendTo($body),
					$wd = $(window),
					$html = $('html');

				$wd.on('scroll.back_to_top', function() {

					if ( $wd.scrollTop() > config.offset ) {
						btn.removeClass('hidden ' + config.transitionOut).addClass(config.transitionIn);
					} else {
						btn.removeClass(config.transitionIn).addClass(config.transitionOut);
					}

				});

				btn.on('click', function() {
					$html.add($body).animate({
						scrollTop: 0
					}, 500, 'easeInExpo');
				});

			},

			tabs: function () {

				var $tempTabs = $('.t_tabs, .t_tour_sections');

				if ( $tempTabs.length ) {
					$tempTabs.terminus_tabs();
				}

			},

			progressBarsAnimation: function(){

				var progressBars = $('.progress_bars');

				if ( !progressBars.length ) return;

				var $wd = $(window), wh = $wd.height() / 1.5;

				progressBars.each(function() {

					var $this = $(this),
						progressBar = $this.find('.vc_single_bar');

					progressBar.each(function(i, el) {
						$(el).find('.vc_bar').css( $this.hasClass('vr') ? 'height' : 'width', 0 );
					});

				});

				$wd.on('scroll.progress_bars', function() {

					var scrollT = $wd.scrollTop();

					progressBars.each(function(i, container) {

						var $this = $(this),
							progressBar = $this.find('.vc_single_bar');

						if ( scrollT > $this.offset().top - wh && !$this.hasClass('anim-progress') ) {

							$this.addClass('anim-progress');

							progressBar.each(function(i, el) {

								var $el = $(el),
									barElement = $el.children('.bar_element'),
									value = barElement.children('.vc_bar').data('percentage-value'),
									title = $el.find('.vc_label'),
									indicator = $el.find('.vc_bar'),
									fullProperty = $this.hasClass('vr') ? 'outerHeight' : 'outerWidth',
									pixelsValue = parseInt(value * barElement[fullProperty]() / 100);

								var animateProperties = {
									'width': pixelsValue
								};

								if ( $this.hasClass('vr') ) {
									animateProperties = {
										'height': pixelsValue
									}
								}

								indicator.animate(animateProperties, {
									duration: 1500,
									easing: 'easeOutQuart',
									progress: function(animation, progress, remainingMs) {
										title.attr('data-value', Math.ceil( indicator[fullProperty]() / barElement[fullProperty]() * 100) );
									}
								});

							});

						}

						if (i == progressBars.length - 1 && $(container).hasClass('anim-progress')) $wd.off('.progress_bars');

					});

				});

				$wd.trigger('scroll.progress_bars');

			},

			pieCharts: function(animation) {

				var	pieCharts = $('.pie_chart');

				if ( !pieCharts.length ) return;

				var $wd = $(window),
					wh = $wd.height() / 1.5,
					pieCollection = [];

				// initialize
				pieCharts.each(function() {

					var $this = $(this), pie,
						color = $this.data('color'),
						defaultColorSettings = {
							fgColor: '#333',
							bgColor: '#f76b6b'
						},
						blackoutColorSettings = {
							fgColor: '#fff',
							bgColor: '#f76b6b'
						};

					if ( color ) {
						defaultColorSettings.bgColor = color;
						blackoutColorSettings.bgColor = color;
					}

					if ( !animation ) {
						defaultColorSettings.percentage = $this.data('value');
						blackoutColorSettings.percentage = $this.data('value');
					}

					if ( $this.data('icon') !== null ) {
						defaultColorSettings.icon = $this.data('icon');
						blackoutColorSettings.icon = $this.data('icon');
					}

					if ( !$this.closest('.vc_row-has-fill').length ) {
						pie = new terminus_pie.init(this, defaultColorSettings);
					} else {
						pie = new terminus_pie.init(this, blackoutColorSettings);
					}

					pie.render();
					pieCollection.push(pie);

				});

				if ( !animation ) return;

				$wd.on('scroll.pie_charts', function() {

					var scrollT = $wd.scrollTop();

					$.each(pieCollection, function(i, pie){

						var canvas = $(pie.parentElement);

						if ( scrollT > canvas.offset().top - wh && !canvas.hasClass('anim-chart') ) {
							pie.setNewValue(canvas.data('value'));
							pie.startAnimate();
							canvas.addClass('anim-chart');
						}

						if ( i == pieCollection.length - 1 && canvas.hasClass('anim-chart') ) $wd.off('.pie_charts');

					});

				});

				$wd.trigger('scroll.pie_charts');

			},

			slideshowCarousel: function () {

				if ( $('.slideshow').length ) {

					var $slideshow = $('.slideshow');

					$slideshow.each(function () {

						var $this = $(this),
							items = $this.data('items') || 1;

						var	length = $this.children().length,
							config = {
								items: items,
								nav: true,
								autoplay: $this.data('autoplay') == 'yes' ? true : false,
								autoplayTimeout: $this.data('autoplaytimeout') ? $this.data('autoplaytimeout') : 4000,
								loop: true,
								smartSpeed: 500,
								video: true,
								autoWidth: $this.data('autowidth') ? true : false,
								videoWidth: false,
								videoHeight: false,
								animateIn: "fadeInLeft",
								animateOut: "fadeOutLeft",
								autoplayHoverPause: true,
								navText: [],
								navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
								rtl: $.terminus_core.ISRTL ? false : true,
								onInitialized: function () {

								},
								onResize: function () {
									var self = this;

									if ( self._width < 992 ) {
										self.settings.items = 1;
									} else {
										self.settings.items = items;
									}
								}
							};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			folioCarousel: function () {

				if ( $('.projects_carousel').length ) {

					var $projects = $('.projects_carousel');

					$projects.each(function () {

						var $this = $(this),
							length = $this.children().length,
							$columns = $this.data('columns') || 4,
							$dataSidebarPortrait = $this.data('sidebar') == 'no_sidebar' ? 3 : 2,
							margin = $this.data('without_spacing') == 1 ? 0 : $this.data('margin') ? $this.data('margin') : 0,
							config = {
								responsive: {
									0:    { items: 1 },
									600:  { items: $dataSidebarPortrait },
									801:  { items: $dataSidebarPortrait },
									1200: { items: $columns }
								},
								animateIn: "fadeInLeft",
								animateOut: "fadeOutLeft",
								margin: margin,
								nav: true,
								smartSpeed: 500,
								navText: [],
								navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
								rtl: $.terminus_core.ISRTL ? false : true,
								onInitialized: function () { },
								onResize: function () { }
							};

						$this.on('initialized.owl.carousel translated.owl.carousel', $.terminus_core_helpers.owlNav($this));

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			toggleArrows: function(event) {
				if ( !event.namespace ) return;
				var carousel = event.relatedTarget,
					element = event.target,
					current = carousel.current();
				$('.nav_next', element).toggleClass('disabled', current === carousel.maximum());
				$('.nav_prev', element).toggleClass('disabled', current === carousel.minimum());
			},

			 clientCarousel: function () {

				var $clients = $('.clients_carousel');

				if ( $clients.length ) {

					$clients.each(function () {

						var $this = $(this),
							length = $this.children().length,
							config = {
								responsive: {
									0:    { items: 2 },
									540:  { items: 3 },
									767:  { items: 4 },
									970:  { items: 5 },
									1025: { items: 6 },
									1290: { items: 7 },
									1580: { items: 9 }
								},
								animateIn: "fadeInLeft",
								animateOut: "fadeOutLeft",
								nav: true,
								loop: true,
								margin: 30,
								smartSpeed: 500,
								navText: [],
								navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
								rtl: $.terminus_core.ISRTL ? false : true,
								onInitialized: function () { },
								onResize: function () { }
							};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			testimonialCarousel: function () {

				if ( $('.testimonials_carousel, .widgets_carousel').length ) {

					var $testimonials = $('.testimonials_carousel, .widgets_carousel');

					$testimonials.each(function () {

						var $this = $(this),
							length = $this.children().length,
							columns = $this.data('columns'),
							navClass = ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'];

							if ( typeof columns == 'undefined' ) { columns = 1; }

						var	config = {
							nav: true,
							items : columns,
							responsive: {
								0:    { items: 1 },
								600:  { items: 1 },
								801:  { items: 1 },
								992:  { items: columns },
								1200: { items: columns }
							},
							animateIn: "fadeInLeft",
							animateOut: "fadeOutLeft",
							loop: true,
							autoplay: true,
							autoplayTimeout: 4000,
							navText: [],
							navClass: navClass,
							rtl: $.terminus_core.ISRTL ? false : true,
							autoplayHoverPause: true,
							autoHeight: true,
							onInitialized: function () {

								var $owl = $(this.$element.context);

								if ( $owl.closest('.vc_row-has-fill').length ) {
									$owl.find('[class*="owl_nav"]').removeClass('rd-white_black').addClass('rd-white');
								}

							}
						};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			blogCarousel: function () {

				var $posts = $('.news_carousel');

				if ( $posts.length ) {

					$posts.each(function () {

						var $this = $(this),
							length = $this.children().length,
							columns = $this.data('columns');

						if ( typeof columns == 'undefined' ) { columns = 1; }

						var	config = {
							responsive: {
								0:    { items: 1 },
								580:  { items: 2, margin: 20 },
								920:  { items: 3 },
								1200: { items: columns }
							},
							nav: true,
							margin: 30,
							smartSpeed: 500,
							items : columns,
							animateIn: "fadeInLeft",
							animateOut: "fadeOutLeft",
							loop: true,
							autoplay: true,
							autoplayTimeout: 4000,
							navText: [],
							navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
							rtl: $.terminus_core.ISRTL ? false : true,
							autoplayHoverPause: true,
							autoHeight: true,
							onInitialized: function () {

								var $owl = $(this.$element.context);

								if ( $owl.closest('.vc_row-has-fill.vc_parallax').length ) {
									$owl.find('[class*="owl_nav"]').removeClass('rd-white_black').addClass('rd-white');
								}

							}
						};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

				if ( $('.entries_slider').length ) {

					var $entries_slider = $('.entries_slider');

					$entries_slider.each(function () {

						var $this = $(this),
							length = $this.children().length,
						config = {
							nav: true,
							smartSpeed: 500,
							items : 1,
							animateIn: "fadeInLeft",
							animateOut: "fadeOutLeft",
							loop: true,
							autoplay: true,
							autoplayTimeout: 4000,
							autoplayHoverPause: true,
							navText: [],
							navClass: ['btn rd-white icon_only huge owl_nav_prev nav_prev', 'btn rd-white icon_only huge owl_nav_next nav_next'],
							rtl: $.terminus_core.ISRTL ? false : true,
							onInitialized: function () {

								var $owl = $(this.$element.context);

								if ( $owl.closest('.vc_row-has-fill').length ) {
									$owl.find('[class*="owl_nav"]').removeClass('rd-white_black').addClass('rd-white');
								}

							}
						};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

				if ( $('.entry_carousel').length ) {

					var $entry = $('.entry_carousel');

					$entry.each(function () {

						var $this = $(this),
							length = $this.children().length,
							config = {
								items: 1,
								nav: true,
								smartSpeed: 500,
								animateIn: "fadeInLeft",
								animateOut: "fadeOutLeft",
								loop: true,
								autoplay: true,
								navText: [],
								navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
								rtl: $.terminus_core.ISRTL ? false : true,
								autoplayTimeout: 4000,
								autoplayHoverPause: true,
								autoHeight: false,
								onInitialized: function () {

									var $owl = $(this.$element.context);

									if ( $owl.closest('.vc_row-has-fill').length ) {
										$owl.find('[class*="owl_nav"]').removeClass('rd-white_black').addClass('rd-white');
									}

								}
							};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			servicesCarousel: function () {

				if ( $('.services_nav').length ) {

					var $services = $('.services_nav');

					$services.each(function () {

						var $this = $(this),
							length = $this.children().length,
							config = {
								responsive: {
									0:    { items: 2, margin: 10 },
									480:  { items: 3, margin: 10 },
									580:  { items: 4 },
									991:  { items: 6 }
								},
								nav: true,
								margin: 20,
								smartSpeed: 500,
								animateIn: "fadeInLeft",
								animateOut: "fadeOutLeft",
								loop: false,
								autoplay: false,
								navText: [],
								navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
								rtl: $.terminus_core.ISRTL ? false : true,
								autoplayHoverPause: false,
								autoHeight: false,
								onInitialized: function () { }
							};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			galleryCarousel: function () {

				if ( $('.fw_projects_carousel').length ) {

					var $gallery = $('.fw_projects_carousel');

					$gallery.each(function () {

						var $this = $(this),
							length = $this.children().length,
							config = {
								responsive: {
									0:    { items: 1 },
									540:  { items: 2 },
									1025: { items: 3 }
								},
								nav: true,
								smartSpeed: 500,
								animateIn: "fadeInLeft",
								animateOut: "fadeOutLeft",
								loop: false,
								autoplay: false,
								navText: [],
								navClass: ['btn rd-white_black owl_nav_prev nav_prev', 'btn rd-white_black owl_nav_next nav_next'],
								rtl: $.terminus_core.ISRTL ? false : true,
								autoplayHoverPause: false,
								autoHeight: false,
								onInitialized: function () {

									var $owl = $(this.$element.context);

									if ( $owl.closest('.vc_row-has-fill').length ) {
										$owl.find('[class*="owl_nav"]').removeClass('rd-white_black').addClass('rd-white');
									}

								}
							};

						if ( length > 1 ) {
							$this.owlCarousel(config);
						}

					});

				}

			},

			counters: function(){

				var counter = $('.counter'),
					$wd = $(window),
					wh = $wd.height() / 1.5;

				if(!counter.length) return;

				counter.each(function(){

					var $c = $(this),
						data = $c.data('amount');

					$c.attr('data-amount', 0);
					$c.data('c-amount', data);

				});

				$wd.on('scroll.counters', function(){

					counter.each(function(i, el){

						var $c = $(el),
							current = 0,
							data = $c.data('c-amount');

						if($wd.scrollTop() > $c.offset().top - wh && !$c.hasClass('counted')){

							$c.addClass('counted');

							var intId = setInterval(function(){

								$c.attr('data-amount', current++);

								if(current > data) clearInterval(intId);

							}, 4);

						}

						if(i == counter.length - 1 && $c.hasClass('counted')) $wd.off('.counters');

					});

				});

				$wd.trigger('scroll.counters');

			},

			preloader: function(delay){

				var $loader = $('#preloader');

				if(delay){

					setTimeout(function(){
						$loader.fadeOut(1000 ,function(){
							$(this).remove();
						});
					}, delay == 0 ? 4 : delay);

				} else {
					$loader.fadeOut(1000 ,function(){
						$(this).remove();
					});
				}

			},

			/**
			** product raring
			**/
			productRating : function(collection){

				var $ratings = collection ? collection : $('.rating');

				$ratings.each(function(){

					$(this).append("<div class='empty_state'><i class='icon-star-empty'></i><i class='icon-star-empty'></i><i class='icon-star-empty'></i><i class='icon-star-empty'></i><i class='icon-star-empty'></i></div><div class='fill_state'><i class='icon-star'></i><i class='icon-star'></i><i class='icon-star'></i><i class='icon-star'></i><i class='icon-star'></i></div>");

					var $this = $(this),
						rating = $this.data("rating"),
						fillState = $this.children('.fill_state'),
						w = $this.outerWidth();

					fillState.css('width', Math.floor(rating / 5 * w));

				});

			},

			sideMenu: function(){

				var body = $('body'),
					container = $('.float_aside_overlay'),
					nav = $('.float_aside');

				if(!container.length) return;

				body.on('click.side_menu', '.float_aside_btn', function(event){

					container.toggleClass('opened');

				}).on('click.sideMenuFocusOut touchend.sideMenuFocusOut', '.float_aside_overlay', function(event){

					if (!$(event.target).closest(nav).length) container.removeClass('opened');

				});

			},

			onePageNavigation: {

				init: function(){

					var self = this;

					self.navigation = $('.navigation.one_page');
					if ( !self.navigation.length ) return;

					self.page = $('html, body');
					self.sticky = $('.sticky_part');
					self.sections = $('.vc_row');
					self.stickyHeight = self.sticky.length && ($(window).width() > 767 && $(window).height() > 500) ? self.sticky.outerHeight() : 0;
					self.isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);

					self.navigation.on('click', 'a[href^="#"]', {self: self}, self.linkHandler);
					$(window).on('scroll.onePage', {self: self}, self.checkCurrentSection);

					self.checkHash();

				},

				checkHash: function(){

					var self = this,
						section = $(window.location.hash);

					if(!section.length) return;
					
					self.scrollTo(section);

				},

				scrollTo: function(section, hash){

					var self = this,
						offset = section.offset().top - self.stickyHeight;

					self.page.stop().animate({
						scrollTop: offset
					}, {
						easing: "easeInOutQuart",
						duration: 1250,
						complete: function(){

							if(!self.isChrome || !hash) return;

							window.location.hash = hash;

						},
						step: function(){

							if(self.isChrome || window.location.hash === hash || !hash) return;

							window.location.hash = hash;

						}
					});

				},

				linkHandler: function(e){

					e.preventDefault();

					var self = e.data.self,
						$this = $(this),
						hash = $this.attr('href'),
						section = $(hash);

					if (section.length) {
						self.scrollTo(section, hash);
					}

				},

				checkCurrentSection: function(event){

					var self = event.data.self,
						scrollPos = $(this).scrollTop(),
						wH = $(window).height();

					if(scrollPos + wH == $(document).height()){

						var section = '#' + self.sections.last().attr('id');

						self.addCurrentClass(section);

						return false;

					}

					self.sections.each(function(i, el){

						var $this = $(el),
							offset = el.offsetTop - self.stickyHeight - 1,
							section;

						if(scrollPos >= offset && scrollPos < offset + el.offsetHeight){

							section = '#' + $this.attr('id');

							self.addCurrentClass(section);

							return false;

						}

					});

				},

				addCurrentClass: function(section){

					var self = this;

					self.navigation.find('a[href="'+section+'"]')
						.parent()
						.addClass('current')
						.siblings()
						.removeClass('current');

				}

			},

			isotope: {

				init: function(){

					var self = this;

					self.container = $('.isotope_container');
					self.loading = false;

					if ( !self.container.length ) return;

					self.loadMoreBtn = $('.load_more');

					if ( self.loadMoreBtn.length ) {
						self.loadMoreBtn.on( 'click', { base: self }, self.loadMore );
					}

					if ( self.container.data('lazy-load') ) {

						self.lazyLoad();
						$(window).on('resize.lazy_load', self.lazyLoad.bind(self));

						self.container.on('layoutComplete', function(){
							self.lazyLoad();
						});

					}

					self.initialize();
					self.filterInit();

					$(window).on('resize.isotope', self.relayout.bind(self));
				},

				config: {
					transitionDuration: '0.55s',
					layoutMode: 'fitRows',
					itemSelector: '.isotope_item',
					isOriginLeft: $.terminus_core.ISRTL ? false : true
				},

				initialize: function(){

					var self = this;

					self.container.each(function() {

						var $this = $(this),
							layout = $this.data('isotope-layout');

						if ( layout === 'masonry' ) self.config.layoutMode = "masonry";

						if ( ($this.data('type-layout') == 'portfolio') && ($this.data('isotope-layout') == 'masonry') ) {

							self.config.masonry = {
								columnWidth: '.grid-sizer'
							}

						}

						$this.isotope(self.config);

					});

				},

				filterInit: function() {

					var self = this;

					$('.isotope_filter').on('click.filter', '[data-filter]', function(event){

						event.preventDefault();

						var $this = $(this),
							filterValue = $this.data('filter');

						$this.addClass('active').siblings().removeClass('active');

						self.container.isotope({ filter: filterValue });

					});

				},

				lazyLoad: function(){

					var self = this,
						w = $(window),
						containerHeight,
						breakpoint,
						OFFSET = 200,
						docHeight = $(document).height();

					setTimeout(function(){

						containerHeight = self.container.outerHeight();
						breakpoint = self.container.offset().top + containerHeight;

						w.on('scroll.lazy_load', { base: self }, function(e) {

							if ( w.scrollTop() + w.height() - OFFSET > breakpoint && !self.container.hasClass('isotope_loading') ) {

								self.container.addClass('isotope_loading');
								self.loadMore(e);

								setTimeout(function(){

									self.container.removeClass('isotope_loading');
									//containerHeight = self.container.outerHeight();
									//breakpoint = self.container.offset().top + containerHeight;

								}, parseFloat(self.config.transitionDuration) * 1000);

							}

						});

						if ( !self.container.hasClass('isotope_loaded') ) {
							self.container.addClass('isotope_loaded');

							if (w.scrollTop() + w.height() > docHeight / 2) w.trigger('scroll.lazy_load');
						}

					}, 500);

				},

				loadMore: function(e) {

					var base = e.data.base;

					if ( e.type == 'click' ) {

						var el	= $(e.target), data = el.data(),
							hide_button = function () {
								el.parent().animate({
									'opacity' : 0
								}, 200, function () {
									$(this).animate( { 'height': 0 }, 400 )
								});
							};

						e.preventDefault();

					} else if ( e.type == 'scroll' ) {
						var el	= base.container.parents('.wpb_content_element').find('.load_more.hidden'), data = el.data();
					}

					if ( $.isEmptyObject(data) ) return;

					if ( base.loading ) return false;
						base.loading = true;

					if ( !data.offset ) { data.offset = 0; }
						data.offset += data.items;

						data.items = data.items_per_page;

					return $.ajax({
						url: terminus_global_vars.ajaxurl,
						type: "POST",
						data: data,
						cache: false,
						success: function( response ) {

							if ( response.indexOf("{terminus-isotope-loaded}") !== -1 ) {

								var response = response.split('{terminus-isotope-loaded}'),
									$newItems = $(response.pop()).filter('.isotope_item');

								if ( $newItems.length > 0 ) {
									base.appendItems( $newItems );
								} else {
									if ( e.type == 'click' ) {
										hide_button();
									}
								}

								base.loading = false;

							} else {

								if ( e.type == 'click' ) {
									hide_button();
								}

							}

						}
					});

				},

				appendItems: function(newItems){

					var base = this;

					base.container
						.append(newItems)
						.isotope('appended', newItems)
						.addClass('global-loader')
						.terminus_images_loaded()
						.then(function() {
							base.container.isotope('layout');
						});

				},

				relayout: function(){

					var self = this;

					if ( self.container.find('.owl_carousel').length ) {

						setTimeout(function() {
							self.container.isotope('layout');
						}, 700 );

					}

				}

			},

			zoomOutTitle: function(){

				var $zoomOut = $('.zoom_out');

				if(!$zoomOut.length || $.terminus_core.ISTOUCH) return;

				var MAXBGSIZE = 2500;

				$zoomOut.css('background-size', MAXBGSIZE);

				$(window).on('scroll.zoom_out', function(){

					var $this = $(this),
						scrollTop = $this.scrollTop();

					$zoomOut.css('background-size', MAXBGSIZE - scrollTop);


				});

			},

			gradientEffectTitle: function(){

				var $gradientEffect = $('.gradient_effect');

				if ( !$gradientEffect.length ) return;

				var $gradientEl = $gradientEffect.children('.gradient_el');

				$(window).on('scroll.gradient_effect', function(){
					var $this = $(this),
						scrollTop = $this.scrollTop();
						$gradientEl.css('opacity', scrollTop / 280);
				});

			},

			uncoveringPageTitle: function(){

				var $uncoveringTitle = $('.uncovering_title');

				if (!$uncoveringTitle.length) return;
					$uncoveringTitle.delay(1000).slideDown();
			},

			scrollSidebar: {

				init: function(base){

					var self = this;
						self.base = base;

					self.sidebar = $('.scroll_sidebar');

					if ( !self.sidebar.length || $.terminus_core.ISTOUCH ) return;

					self.container = self.sidebar.closest('.folio-container');
					self.w = $(window);
					self.sticky = $('.sticky_part');
					self.PADDING = 70;

					self.updateSidebarData();

					self.w.on('resize.sidebarDataUpdate', self.updateSidebarData.bind(self));

				},

				updateSidebarData: function(){

					var self = this;

					self.containerOffset = self.container.offset().top;
					self.containerNaturalHeight = self.container.height();
					self.offset = self.sidebar.offset().top;
					self.sidebarHeight = self.sidebar.outerHeight();
					self.breakpoint = (self.containerNaturalHeight + self.containerOffset) - self.sidebarHeight;

					if(self.w.height() < self.sidebarHeight + self.PADDING + 62 || self.w.width() + $.terminus_core.helpers.getScrollWidth() < 768) self.destroyScrollSidebar(); // 62 - stickyHeight
					else self.initializeScrollSidebar();

				},

				move: function(position){

					var self = this;

					self.sidebar.stop().animate({
						top: position
					});

				},

				checkPosition: function(){

					var self = this,
						base = self.base,
						scrollTop = self.w.scrollTop(), stickyHeight;

						if ( self.sticky.length ) {
							stickyHeight = self.sticky.outerHeight();

							if ( base.adminbar.length ) {
								stickyHeight = stickyHeight + base.adminbar.outerHeight();
							}

						} else {
							stickyHeight = 0;
						}

					if ( scrollTop > self.breakpoint ) {

						self.move(self.containerNaturalHeight - self.sidebarHeight);

					} else if ( self.offset - stickyHeight < scrollTop ) {

						self.move(scrollTop - self.offset + stickyHeight + self.PADDING );

					} else {
						self.move(0);
					}

				},

				initializeScrollSidebar: function(){

					var self = this;

					if(self.w.data('scroll-sidebar-initialized')) return;

					self.w.on('scroll.sidebar', self.checkPosition.bind(self));
					self.w.data('scroll-sidebar-initialized', true);

				},

				destroyScrollSidebar: function(){

					var self = this;

					self.w.off('scroll.sidebar');
					self.w.data('scroll-sidebar-initialized', false);
					self.move(0);

				}

			}

		},

		helpers: {

			fancyboxValidate: function(){

				var fb = $('.fancybox');

				if(!fb.length) return;

				fb.each(function(){
					$(this).attr('rel', $(this).attr('data-rel'));
				});

			},

			fillTheEmptyPlace: {

				init: function (base) {

					var self = this;

					self.body = base.body;
					self.pageWrap = base.pageWrap;

					self.checkPageHeight();

					$(window).on('resize.emptyPlace', self.checkPageHeight.bind(self));

				},

				updatePageData: function(){

					var self = this;

					self.removePadding();

					self.dH = $(document).height();
					self.bH = self.body.outerHeight();
				},

				checkPageHeight: function(){

					var self = this;

					self.updatePageData();

					if(self.bH < self.dH) self.setPadding();

				},

				setPadding: function(){

					var self = this;

					var padding = (self.dH - self.bH) / 2;

					self.pageWrap.css({
						'padding-top': padding,
						'padding-bottom': padding
					});

				},

				removePadding: function(){

					var self = this;

					self.pageWrap.css({
						'padding-top': 0,
						'padding-bottom' : 0
					});

				}

			},

			responsiveOverlayBox: function(){

				var overlays = $('.overlay_box'),
					productBoxes = $('.product_box');

				overlays.each(function(){

					var $this = $(this),
						maxImgSize = $this.find('img')[0].naturalWidth;

					$this.add($this.closest('.project, .team_member')).css('max-width', maxImgSize);

				});

				productBoxes.each(function(){

					var $this = $(this),
						maxImgSize = $this.find('.product_images').find('img')[0].naturalWidth;

					$this.css('max-width', maxImgSize);

				});

			},

			getScrollWidth: function(){

				var elem = document.createElement("div"),
					width;

				elem.style.position = "absolute";
				elem.style.width = "200px";
				elem.style.height = "200px";
				elem.style.top = "-9999px";
				elem.style.left = "-9999px";
				elem.style.overflow = "scroll";

				document.body.appendChild(elem);

				width = elem.offsetWidth - elem.clientWidth;

				document.body.removeChild(elem);

				return width;

			},

			productBoxesTouch: function(){

				var $box = $('.product_box');

				if(!$box.length) return;

				var $productLink = $box.find('.product_images');

				$productLink.on('click', function(e){

					var $this = $(this);

					if(!$this.hasClass('prevented')){

						e.preventDefault();

						$productLink.removeClass('prevented').closest('.product_image_area').removeClass('active');
						$this.addClass('prevented').closest('.product_image_area').addClass('active');

					}

				});

				$(document).on('click.productBoxFocusOut', function(e){

					if(!$(e.target).closest($box).length){

						$productLink.removeClass('prevented').closest('.product_image_area').removeClass('active');
						
					}

				});

			},

			entriesTouch: function(){

				var $entry = $('.entry.type_2');

				if(!$entry.length) return;

				$entry.on('click.entry_touch', function(){

					var $this = $(this);

					$entry.removeClass('active');
					$this.addClass('active');

				});

				$(document).on('click.entryFocusOut', function(e){

					if(!$(e.target).closest($entry).length){

						$entry.removeClass('active');
						
					}

				});

			},

			isIE: function() {
  				var myNav = navigator.userAgent.toLowerCase();
  				return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
  			},

			setMaxHeight: function(row, selector){

				var max = 0,
					details = row.find(selector).css('height', 'auto');

				details.each(function(i,el){
					var oH = $(el).outerHeight();
					if(oH > max) max = oH;
				});

				details.css('height', max);

			}

		},

		stickyHeader: {

			init: function(base) {

				this.sticky = base.sticky;

				if ( !this.sticky.length ) return;

				this.w = $(window);
				this.body = base.body;
				this.header = base.header;
				this.scrollWidth = $.terminus_core.helpers.getScrollWidth();
				this.stickyHeight = this.sticky.outerHeight();
				this.stickyOffsetTop = this.sticky.offset().top;
				this.headerTransparentType = this.header.hasClass('transparent_type');
				this.content = base.pageWrap;

				if ( base.adminbar.length ) {
					this.stickyOffsetTop = this.stickyOffsetTop - 32;
				}

				this.contentOffset = this.content.offset().top - this.stickyHeight;

				this.initHeaderParameters(base);
				this.toggleSticky();
				this.bindEvents();

			},

			initHeaderParameters: function() {

				var self = this;
					self.disableSticky();

				if ( self.w.width() + self.scrollWidth < 768 ) {
					self.w.off('scroll.sticky');
					return false;

				} else {

					self.w.off('resize.sticky');
					self.bindEvents();

				}

				self.hHeight = self.stickyHeight;
				self.hOffset = self.stickyOffsetTop;
				self.contentOffset = self.content.offset().top - self.stickyHeight;
				self.sticky.data('stickyInit', true);
				self.toggleSticky();

			},

			toggleSticky: function() {

				var self = this;

				if ( self.w.scrollTop() > self.hOffset && !self.sticky.hasClass('sticky_enabled') ) {
					self.sticky.addClass('sticky_enabled').closest('.header_section').addClass('over');
					self.disableEmptyArea(true);
				} else if( self.w.scrollTop() <= self.hOffset ) {
					self.sticky.removeClass('sticky_enabled').closest('.header_section').removeClass('over');
					self.disableEmptyArea(false);
				}

			},

			disableSticky: function() {

				var self = this;

				self.sticky.removeClass('sticky_enabled');
				self.disableEmptyArea(false);

			},

			bindEvents: function(){

				var self = this;

				self.w.on('scroll.sticky', function(){
					self.toggleSticky();
				});

				self.w.on('resize.sticky', self.initHeaderParameters.bind(self));

			},

			disableEmptyArea: function(isNeed) {

				var self = this;

				if (self.headerTransparentType) return;

				if ( isNeed ) {
					self.body.css('padding-top', self.hHeight);
				} else {
 					self.body.css('padding-top', 0);
				}

			}

		},

		navInit: {

			init: function (base) {

				this.createResponsiveButtons(base);
				this.navProcess(base);

				if ( $.terminus_core.ISTOUCH ) {
					this.touchNavMobileNavigation(base);
					this.touchNavHeaderNavigation(base);
				}
			},

			navProcess: function (base) {

				var $window = $(window);

				base.navInit.touchNav(base, $window);

				$window.resize(function (e) {
					setTimeout(function () {
						base.navInit.touchNav(base, e.currentTarget);
					}, 30);
				});

			},

			applyHeight: function () {

				var base = this, window_h = $(window).height(), height;

				if ( base.navMobile.find('.mega_main_menu_ul').length ) {
					height = base.navMobile.find('.mega_main_menu_ul').outerHeight(true) + 20;
				} else {
					height = base.navMobile.children('ul').outerHeight(true);
				}

				if ( window_h > height ) { height = window_h; }

				base.wrapper.css({
					height: height
				}).addClass('active');

			},

			touchNav: function (base, target) {

				var self = this;

				if ( $.terminus_core.ISTOUCH || $(target).width() < 993 ) {

					if ( !base.navMobile.children().length ) {
						if ( base.navMain.children('#mega_main_menu').length ) {
							base.navMobile.append(base.navMain.children().children().html());
						} else {
							base.navMobile.append(base.navMain.html());
						}
					}

					base.navButton.on($.terminus_core.EVENT, function (e) {
						e.preventDefault();

						if ( !base.wrapper.is('.active') ) {
							self.applyHeight.call(base);
						}
					});

					base.navHide.on($.terminus_core.EVENT, function (e) {
						e.preventDefault();
						if ( base.wrapper.is('.active') ) {

							$('html, body').animate({ scrollTop: 0 }, 0);

							base.wrapper.css({
								height: 'auto'
							}).removeClass('active');
						}
					});

				} else {
					base.navMobile.children().remove();
				}
			},

			touchNavMobileNavigation: function (base) {
				var self = this;

				base.navMobile
					.on($.terminus_core.EVENT, 'a, span', function (e) {
						var $this = $(this).parent('li'),
							$submenu = $this.children('ul.sub-menu, ul.submenu, ul.children, .mega_dropdown');

						if ( $this.hasClass('li.menu-item-has-children, li.page_item_has_children') ) return;

						if ( $submenu.length ) {
							e.preventDefault();

							$submenu.slideToggle(function () {
								self.applyHeight.call(base);
								$this.toggleClass('open-menu');
							});
						}

					});
			},

			touchNavHeaderNavigation: function (base) {
				var clicked = false;

				$("#header li.menu-item-has-children > a, li.cat-parent > a, #header li.page_item_has_children > a").on($.terminus_core.EVENT, function (e) {
					if ( clicked != this ) {
						e.preventDefault();
						clicked = this;
					}
				});

				base.navMobile.find('a').off($.terminus_core.EVENT);

			},

			createResponsiveButtons : function (base) {

				var buttonData = {
					'class' : 'responsive-nav-button'
				}

				if ( !base.navMobile.length ) return;

				base.navButton = $('<span></span>', buttonData).insertBefore(base.navMain);

				base.navHide = $('<a></a>', {
					id: 'advanced-menu-hide',
					'href' : 'javascript:void(0)'
				}).insertBefore(base.navMobile);

			}

		},

		verticalNavigation: {

			init: function() {

				var self = this;

				self.navigation = $('.vertical_navigation, .widget_nav_menu');

				if ( !self.navigation.length ) return;

				self.navigation.each(function (id, el) {
					$(el).on('click.' + id, 'a, .item_link', self.linkHandler);
				});

			},

			linkHandler: function(e) {

				var $this = $(this);

				if ( !$this.parent().hasClass('menu-item-has-children') ) return;

				if ( !$this.hasClass('prevented') ) {

					e.preventDefault();

					$this.addClass('prevented')
						.next()
						.stop()
						.slideDown(700, 'easeInOutQuart')
						.parent()
						.addClass('t_active')
						.siblings('.menu-item-has-children')
						.removeClass('t_active')
						.children('a, span')
						.removeClass('prevented')
						.next('.sub-menu, .submenu, .mega_dropdown')
						.stop()
						.slideUp(700, 'easeInOutQuart');

				}

			}

		},

		/**
		**	Handling animation when page has been scrolled
		**/
		animatedContent : function(){

			$("[data-animation]").each(function() {

				var self = $(this),
					scrollFactor = self.data('scroll-factor') ? self.data('scroll-factor') : -240;

				if ( $(window).width() > 767 ) {

					self.appear(function() {

						var delay = (self.attr("data-animation-delay") ? self.attr("data-animation-delay") : 1);

						if(delay > 1) self.css("animation-delay", delay + "ms");
						self.addClass("terminus_visible " + self.attr("data-animation"));
						self.on($.terminus_core.ANIMATIONEND, function(){
							self.addClass('animation_end');
						});

					}, {accX: 0, accY: scrollFactor});

				} else {
					self.addClass("terminus_visible");
				}

			});

		},

		events: {

			closeBtn: function(){

				$('body').on('click.close', '.close:not(.arcticmodal-close, table .close, .remove-product)', function(event){

					event.preventDefault();

					var $this = $(this);

					$this.parent().animate({
						opacity: 0
					}, function(){

						$(this).slideUp(function(){

							if($this.closest('#header').length) $.terminus_core.stickyHeader.initHeaderParameters();
							$(this).remove();

						});

					});

				});

			},

			dropdown: function() {

				var self = this;
					self.open = false;

				$('body').on('click', '#language_btn, #currency_btn, #shopping_cart_btn', function(e) {
					e.preventDefault();

					var $this = $(this),
						dropdown = $this.next('.dropdown');

					if ( $this.hasClass('active') && self.open == true ) {
						//dropdown.add($this).removeClass('active');
						self.open = false;
					} else {
						//dropdown.add($this).addClass('active');
						self.open = true;
					}

					$this.next(dropdown).add($this).toggleClass('active');


				});

				$(document).on('click.close_dropdown', function(e) {

					if ( !$(e.target).closest('.dropdown_wrap').length && self.open == true ) {

						var dropdown = $('.dropdown');
							dropdown.add(dropdown.prev()).removeClass('active');
							self.open = false;
					}

				});

			},

			openModalSearch: function () {

				$('body').on('click.search', '.search_btn', function (e) {

					e.preventDefault();

					var $this = $(this),
						data = {};

					data.action = $this.data('modal-action');
					data._wpnonce = $this.data('modal-nonce');

					if (data.action == 'undefined') return;

					$.arcticmodal({
						type: 'ajax',
						url: terminus_global_vars.ajaxurl,
						ajax: {
							type: 'POST',
							data: data,
							cache: false,
							success: function (data, el, response) {
								data.body.html(response);
							}
						},
						afterLoadingOnShow: function (obj) {


						},
						overlay: {
							css: {
								backgroundColor: "#000",
								opacity: '.7'
							}
						},
						afterClose: function () {


						}
					});

				});

			},

			openModalShare: function () {

				$('body').on('click.shareButton', '.post-share-button', function (e) {

					e.preventDefault();

					var $this = $(this),
						data = {};

					data.action = $this.data('modal-action');
					data.post_id = $this.data('post-id');
					data._wpnonce = $this.data('modal-nonce');

					if ( data.action == 'undefined' ) return;

					$.arcticmodal({
						type: 'ajax',
						url: terminus_global_vars.ajaxurl,
						ajax: {
							type: 'POST',
							data: data,
							cache: false,
							success: function (data, el, response) {
								data.body.html(response);
							}
						},
						afterLoadingOnShow: function (obj) { },
						overlay: {
							css: {
								backgroundColor: "#000",
								opacity: '.7'
							}
						},
						afterClose: function () { }
					});

				});

			},

			moveScroll: function() {

				var $moveScrollElements = $('.move_scroll');
				if ( !$moveScrollElements.length ) return;

				$moveScrollElements.on('mousemove.move_scroll mouseenter.move_scroll drag.move_scroll', function(event) {

					var $this = $(this),
						innerElement = $this.children('.move_scroll_inner'),
						containerHeight = $this.outerHeight(),
						containerPos = $this.offset().top,
						centerPoint = containerHeight / 2,
						totalInnerHeight = 0,
						mousePos = event.pageY - containerPos, currentContentPos;

					innerElement.children().each(function(){

						var $this = $(this);

						if(!$this.is(":visible")) return;

						var	offsetTop = parseInt($this.css('margin-top')),
							offsetBottom = parseInt($this.css('margin-bottom'));

						totalInnerHeight += (offsetTop + offsetTop + $this.outerHeight());

					});

					innerElement.css('height', totalInnerHeight);

					currentContentPos = mousePos / containerHeight * totalInnerHeight - centerPoint;

					$this.finish();

					$this.animate({
						scrollTop: currentContentPos
					}, 500);


				});

			}

		}

	};

	$(document).ready(function(){
		$.terminus_core.DOMReady();
	});

	$(window).load(function(){
		$.terminus_core.windowLoad();
	});

})(jQuery);

;(function($){
	"use strict";

	$(document).ready(function(){

		/* ------------------------------------------------
		 Countdown
		 ------------------------------------------------ */

		var $countdown = $('.shortcode-countdown .countdown');

		if ( $countdown.length ) {

			$countdown.each(function() {

				var $this = $(this),
					endDate = $this.data('terminal-date');

				$this.countdown({
					until: new Date(endDate),
					format: 'dHMS',
					labels: ['years', 'months', 'weeks', 'days', 'hours', 'minutes', 'seconds'],
					labels1: ['year', 'month', 'week', 'day', 'hour', 'minute', 'second'],
					isRTL: $.terminus_core.ISRTL ? false : true
				});

			});

		}

		/* ------------------------------------------------
		 Custom Select
		 ------------------------------------------------ */

		var $customSelect = $('.custom_select');

		if ( $customSelect.length ) $customSelect.terminus_custom_select();

		/* ------------------------------------------------
		 End of Custom Select
		 ------------------------------------------------ */

	});

	$(window).load(function() {

		/* ------------------------------------------------
		 Parallax (!No Touch!)
		 ------------------------------------------------ */

		var $parallaxElements = $('.md_no-touchevents .page_title.parallax, .md_no-touchevents .vc_parallax-inner');

		if ( $parallaxElements.length ) {
			$parallaxElements.each(function() {
				$(this).terminus_parallax( "50%", 0.4 );
			});
		}

		/* ------------------------------------------------
		 End of Parallax
		 ------------------------------------------------ */

	});

})(jQuery);