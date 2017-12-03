<?php

if (!class_exists('TERMINUS_HELPER')) {

	class TERMINUS_HELPER {

		/*	Get Registered Sidebars
		/* ---------------------------------------------------------------------- */

		public static function get_registered_sidebars($sidebars = array(), $exclude = array()) {
			global $wp_registered_sidebars;

			foreach ($wp_registered_sidebars as $sidebar) {
				if (!in_array($sidebar['name'], $exclude)) {
					$sidebars[$sidebar['name']] = $sidebar['name'];
				}
			}
			return $sidebars;
		}

		/*	Check page layout
		/* ---------------------------------------------------------------------- */

		public static function check_page_layout ($post_id = false) {
			global $terminus_config;

			$result = false;
			$sidebar_position = 'sidebar_archive_position';

			if ( empty($post_id) ) $post_id = terminus_post_id();

			if ( is_page() || is_search() || is_attachment() ) {
				$sidebar_position = 'sidebar_page_position';
			}
			if ( is_archive() ) {
				$sidebar_position = 'sidebar_archive_position';
			}
			if ( is_single() ) {
				$sidebar_position = 'sidebar_post_position';
			}
			if ( is_singular() ) {
				$result = rwmb_meta( 'terminus_page_sidebar_position', '', $post_id );
			}
			if ( is_singular('portfolio') ) {
				$result = 'no_sidebar';
			}
			if ( is_404() ) {
				$result = 'no_sidebar';
			}
			if ( is_post_type_archive('portfolio') || is_tax('portfolio_categories') ) {
				$result = terminus_get_option('sidebar_portfolio_archive_position');
			}
			if ( is_post_type_archive('testimonials') || is_singular('testimonials') || is_tax('testimonials_category') ) {
				$result = 'no_sidebar';
			}
			if ( is_post_type_archive('team-members') || is_singular('team-members') || is_tax('team_category') ) {
				$result = 'no_sidebar';
			}

			if ( terminus_is_shop_installed() ) {

				if ( terminus_is_product() ) {
					$result_sidebar_position = rwmb_meta( 'terminus_page_sidebar_position', '', $post_id );
					if (empty($result_sidebar_position)) {
						$result = terminus_get_option('sidebar_product_singular_position');
					} else {
						$result = $result_sidebar_position;
					}
				}

				if ( is_post_type_archive('product') || terminus_is_product_category() || terminus_is_product_tag() ) {

					if ( terminus_is_product_category() ) {

						$result = terminus_get_meta_value('sidebar_position');

						if ( empty($result) ) {
							$result = terminus_get_option('sidebar_product_archive_position');
						}

					} else {
						$result = terminus_get_option('sidebar_product_archive_position');
					}

				}
			}

			if ( !$result ) {
				$result = terminus_get_option($sidebar_position);
			}

			if ( !$result ) {
				$result = 'sbr';
			}

			if ( $result ) {
				$terminus_config['sidebar_position'] = $result;
			}
		}

		public static function check_header_classes( $post_id = false ) {
			global $terminus_config;

			$result = array();

			if ( empty($post_id) ) $post_id = terminus_post_id();

			$result['header_style'] = rwmb_meta( 'terminus_header_style', '', $post_id );

			if ( empty($result['header_style']) ) {
				$header_type = terminus_get_option('header-type');
				if ( absint($header_type) ) {
					$result['header_style'] = 'style_' . absint($header_type);
				}
			}

			switch( $result['header_style'] ) {
				case 'style_6':
				case 'style_8':
				case 'style_9':
					$result['white_style'] = 'white_style';
				break;
				case 'style_2':
				case 'style_3':
				case 'style_4':
				case 'style_7':
				case 'style_11':
					$result['transparent_type'] = 'transparent_type';
				break;
				case 'style_10':
					$result['move_scroll'] = 'move_scroll';
					$result['transparent_type'] = 'transparent_type';
				break;
			}

			$terminus_config['header_classes'] = implode( ' ', array_values($result) );
			$terminus_config['header_style'] = $result['header_style'];
		}

		public static function template_layout_class( $key, $echo = false ) {
			global $terminus_config;

			if ( !isset($terminus_config['header_classes']) )   { self::check_header_classes(); }
			if ( !isset($terminus_config['sidebar_position']) ) { self::check_page_layout(); }

			$return = $terminus_config[$key];

			if ( $echo == true ) {
				echo $return;
			} else {
				return $return;
			}
		}

		/*  Main Navigation
		/* ---------------------------------------------------------------------- */

		public static function main_navigation( $menu_class = 'navigation', $theme_location = 'primary' ) {

			if ( is_array($menu_class) ) {
				$menu_class = implode(" ", $menu_class);
			}

			$defaults = array(
				'container' => 'ul',
				'menu_class' => $menu_class,
				'theme_location' => $theme_location
			);

//			$nav_menu = terminus_get_option( 'nav-menu-primary', '' );
//
//			if ( isset($nav_menu) && !empty($nav_menu) && $theme_location == 'primary' ) {
//				$defaults['menu'] = $nav_menu;
//			}

			wp_nav_menu( $defaults );

		}

		public static function output_widgets_html($view, $data = array()) {
			@extract($data);
			ob_start();
			include( get_template_directory() . '/includes/widgets/templates/' . $view . '.php' );
			return ob_get_clean();
		}

		public static function get_post_attachment_image($attachment_id, $dimensions, $crop = true) {
			$img_src = wp_get_attachment_image_src($attachment_id, $dimensions);
			$img_src = $img_src[0];
			return self::get_image($img_src, $dimensions, $crop);
		}

		public static function get_post_featured_image($post_id, $dimensions, $crop = true) {
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), '');
			$img_src = $img_src[0];
			return self::get_image($img_src, $dimensions, $crop);
		}

		public static function get_image($img_src, $dimensions, $crop = true) {
			if (empty($dimensions)) return $img_src;

			$sizes = explode('*', $dimensions);
			$src = aq_resize($img_src, $sizes[0], $sizes[1], $crop);

			if ( !$src ) {
				return $img_src;
			}
			return $src;
		}

		public static function get_the_post_thumbnail ($post_id, $dimensions, $crop = true, $thumbnail_atts = array(), $image_atts = array()) {
			$atts = '';
			$sizes = array_filter(explode("*", $dimensions));
			if (is_array($sizes) && !empty($sizes)) {
				$atts = "width={$sizes[0]} height={$sizes[1]}";
			}
			return '<img '. esc_attr($atts) .' src="' . self::get_post_featured_image($post_id, $dimensions, $crop) . '" ' . self::create_atts_string($thumbnail_atts) . ' ' . self::create_atts_string($image_atts) . ' />';
		}

		public static function get_the_thumbnail ($attach_id, $dimensions, $crop = true, $thumbnail_atts = array(), $image_atts = array()) {
			$atts = '';
			$sizes = array_filter(explode("*", $dimensions));
			if (is_array($sizes) && !empty($sizes)) {
				$atts = "width={$sizes[0]} height={$sizes[1]}";
			}
			return '<img '. esc_attr($atts) .' src="' . self::get_post_attachment_image($attach_id, $dimensions, $crop) . '" ' . self::create_data_string($thumbnail_atts) . ' ' . self::create_atts_string($image_atts) . ' />';
		}

		public static function create_data_string($data = array()) {
			$data_string = "";

			if (empty($data)) return;

			foreach ($data as $key => $value) {
				if (is_array($value)) $value = implode(", ", $value);
				if (empty($value)) continue;
				$data_string .= " data-$key='$value' ";
			}
			return $data_string;

		}

		public static function create_atts_string($data = array()) {
			$string = "";

			if (empty($data)) return;

			foreach ($data as $key => $value) {

				if (is_array($value)) $value = implode(", ", $value);

				$string .= " $key='{$value}' ";
			}
			return $string;

		}

		public static function create_data_string_animation( $animation, $delay = 0, $scroll_factor = '-120' ) {
			$data_string = array();

			if ( !empty($animation) ) {
				$data_string['animation'] = esc_attr($animation);
			}
			if ( 0 != $delay ) {
				$data_string['animation-delay'] = esc_attr($delay);
			}
			if ( !empty($scroll_factor) ) {
				$data_string['scroll-factor'] = esc_attr($scroll_factor);
			}

			return self::create_data_string($data_string);
		}

		public static function which_video_service( $video_url ) {
			$videos = array();
			$videoIdRegex = null;

			if (strpos($video_url, 'youtube.com/watch') !== false || strpos($video_url, 'youtu.be/') !== false) {
				preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video_url, $matches);
				$video_id = $matches[0];

				if (!empty($video_id)) {
					$videos['ytid'] = trim($video_id);
					$videos['videoattributes'] = "version=3&amp;enablejsapi=1&amp;html5=1&amp;volume=100&amp;hd=1&amp;wmode=opaque&showinfo=0&ref=0;";
				}
			} elseif (strpos($video_url, 'vimeo.com') !== false) {

				if (strpos($video_url, 'player.vimeo.com') !== false) {
					$videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
				} else { $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i'; }

				if ($videoIdRegex !== null) {
					if (preg_match($videoIdRegex, $video_url, $results)) {
						$video_id = $results[1];
					}
					if (!empty($video_id)) {
						$videos['vimeoid'] = trim($video_id);
						$videos['videoattributes'] = "title=0&byline=0&portrait=0&api=1";
					}
				}

			} else {
				if (preg_match("/\.mp4$/", $video_url)) {
					$videos['videomp4'] = trim($video_url);
				} else if (preg_match("/\.ogv$/", $video_url)) {
					$videos['videoogv'] = trim($video_url);
				} else if (preg_match("/\.webm$/", $video_url)) {
					$videos['videowebm'] = trim($video_url);
				}
			}

			return self::create_data_string($videos);
		}

		public static function hex2rgba($color, $opacity = false) {

			$default = 'rgb(0,0,0)';

			//Return default if no color provided
			if(empty($color))
				return $default;

			//Sanitize $color if "#" is provided
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return $default;
			}

			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);

			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}

			//Return rgb(a) color string
			return $output;
		}

	}

}

/*	Blog alias
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_blog_alias')) {

	function terminus_blog_alias ( $format = 'standard', $image_size = array(), $blog_style = '', $layout = '', $columns ) {
		global $terminus_config;
		$sidebar_position = $terminus_config['sidebar_position'];

		if ( $layout != 'layout_4' ) $format = 'standard';

		if ( is_array($image_size) && !empty($image_size) ) {
			$alias = ($format == 'audio' || $format == 'video') ? $image_size[1] : $image_size[0];
			return $alias;
		}

		switch ( $blog_style ) {

			case 'blog-small-thumbs':

				switch ( $format ) {
					case 'standard':
					case 'gallery':
						$alias = ($sidebar_position == 'no_sidebar') ? '750*500' : '360*240';
					break;
					case 'audio':
					case 'video':
						$alias = ($sidebar_position == 'no_sidebar') ? array(750, 500) : array(360, 240);
					break;
					default:
						$alias = ($sidebar_position == 'no_sidebar') ? '750*500' : '360*240';
						break;
				}

				return $alias;

			break;
			case 'blog-big-thumbs':

				switch ( $format ) {
					case 'standard':
					case 'gallery':
						$alias = ($sidebar_position == 'no_sidebar') ? '1140*760' : '750*500';
					break;
					case 'audio':
					case 'video':
						$alias = ($sidebar_position == 'no_sidebar') ? array(1140, 760) : array(750, 500);
					break;
					default:
						$alias = ($sidebar_position == 'no_sidebar') ? '1140*760' : '750*500';
						break;
				}

				return $alias;

			break;
			case 'blog-grid':
			case 'blog-masonry':

				switch ( $columns ) {
					case 2:

					switch ( $format ) {
						case 'standard':
						case 'gallery':
							$alias = ($sidebar_position == 'no_sidebar') ? '555*370' : '555*370';
						break;
						case 'audio':
						case 'video':
							$alias = ($sidebar_position == 'no_sidebar') ? array(555, 370) : array(555, 370);
						break;
						default:
							$alias = ($sidebar_position == 'no_sidebar') ? '555*370' : '555*370';
							break;
					}

					break;
					case 3:
					case 4:

					switch ( $format ) {
						case 'standard':
						case 'gallery':
							$alias = ($sidebar_position == 'no_sidebar') ? '445*300' : '445*300';
						break;
						case 'audio':
						case 'video':
							$alias = ($sidebar_position == 'no_sidebar') ? array(450, 300) : array(450, 300);
						break;
						default:
							$alias = ($sidebar_position == 'no_sidebar') ? '445*300' : '445*300';
							break;
					}

					break;
					default:

						switch ( $format ) {
							case 'standard':
							case 'gallery':
								$alias = ($sidebar_position == 'no_sidebar') ? '445*300' : '445*300';
							break;
							case 'audio':
							case 'video':
								$alias = ($sidebar_position == 'no_sidebar') ? array(450, 300) : array(450, 300);
							break;
							default:
								$alias = ($sidebar_position == 'no_sidebar') ? '445*300' : '445*300';
								break;
						}

					break;

				}

				return $alias;

			break;

		}


	}
}

/*	Debug function print_r
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_print_r')) {
	function terminus_print_r( $arr ) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}

/* 	Pagination
/* ---------------------------------------------------------------------- */

if( !function_exists( 'terminus_pagination' ) ) {

	function terminus_pagination( $entries = '', $args = array(), $range = 10 ) {

		global $wp_query;

		$paged = (get_query_var('paged')) ? get_query_var('paged') : false;

		if ( $paged === false ) $paged = (get_query_var('page')) ? get_query_var('page') : false;
		if ( $paged === false ) $paged = 1;

		if ($entries == '') {

			if ( isset( $wp_query->max_num_pages ) )
				$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		} else {
			$pages = $entries->max_num_pages;
		}

		if ( 1 != $pages ) { ob_start(); ?>

			<div class="section_btn">
				<ul class="pagination">
					<?php if( $paged > 1 ):  ?>
						<li><a class='btn rd-grey small page-prev' href='<?php echo esc_url(get_pagenum_link( $paged - 1 )) ?>'><?php esc_html_e('Prev', 'terminus') ?></a></li>
					<?php endif; ?>

					<?php for( $i=1; $i <= $pages; $i++ ): ?>
						<?php if ( 1 != $pages &&( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $range ) ): ?>
							<?php $class = ( $paged == $i ) ? " active" : ''; ?>
							<li><a class="btn rd-grey small <?php echo esc_attr($class) ?>" href='<?php echo esc_url(get_pagenum_link( $i )) ?>'><?php echo esc_html($i) ?></a></li>
						<?php endif; ?>
					<?php endfor; ?>

					<?php if ( $paged < $pages ):  ?>
						<li><a class='btn rd-grey small page-next' href='<?php echo esc_url(get_pagenum_link( $paged + 1 )) ?>'><?php esc_html_e('Next', 'terminus') ?></a></li>
					<?php endif; ?>
				</ul>
			</div><!--/ .section_btn-->

		<?php return ob_get_clean(); }
	}
}

/* Shop Corenavi
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_shop_corenavi')) {

	function terminus_shop_corenavi($pages = "", $a = array(), $args = array()) {
		global $wp_query;

		if (empty($args['tag'])) $args['tag'] = 'footer';
		if (empty($args['class'])) $args['class'] = 'bottom_box';

		if ($pages == '') {
			$max = $wp_query->max_num_pages;
		} else {
			$max = $pages;
		}

		ob_start(); ?>

		<?php if ($max > 1): ?>

			<div class="woocommerce-pagination">

				<<?php echo esc_attr($args['tag']) ?> class="<?php echo esc_attr($args['class']); ?> on_the_sides">

				<div class="left_side">
					<?php woocommerce_result_count(); ?>
				</div><!--/ .left_side-->

				<div class="right_side">
					<div class="pagination">
						<?php echo woocommerce_pagination(); ?>
					</div><!--/ .pagination-->
				</div><!--/ .right_side-->

				</<?php echo esc_attr($args['tag'] ) ?>>

			</div>

		<?php endif;

		return ob_get_clean();
	}

}