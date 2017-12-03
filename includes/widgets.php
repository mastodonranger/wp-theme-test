<?php

/*  Register Widget Areas
/* ----------------------------------------------------------------- */

if (!function_exists('terminus_widgets_register')) {

	function terminus_widgets_register () {

		$before_widget = '<div id="%1$s" class="widget %2$s">';

		$widget_args = array(
			'before_widget' => $before_widget,
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget_title">',
			'after_title' => '</h3>'
		);

		// General Widget Area
		register_sidebar(array(
			'name' => 'General Widget Area',
			'id' => 'general-widget-area',
			'description'   => esc_html__('For all pages and posts.', 'terminus'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		// Aside Panel Widget Area
		register_sidebar(array(
			'name' => 'Aside Panel Widget Area',
			'id' => 'aside-panel-widget-area',
			'description'   => esc_html__('For aside panel.', 'terminus'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		for ($i = 1; $i <= 25; $i++) {
			register_sidebar(array(
				'name' => 'Footer Row - widget ' . $i,
				'id' => 'footer-row-' . $i,
				'before_widget' => $widget_args['before_widget'],
				'after_widget' => $widget_args['after_widget'],
				'before_title' => $widget_args['before_title'],
				'after_title' => $widget_args['after_title']
			));
		}
	}

	add_action('widgets_init', 'terminus_widgets_register');

}

/*	Include Widgets
/* ----------------------------------------------------------------- */

if (!function_exists('terminus_unregistered_widgets')) {
	function terminus_unregistered_widgets () {
		unregister_widget( 'LayerSlider_Widget' );
	}
	add_action('widgets_init', 'terminus_unregistered_widgets', 1);
}

/*	Widget Facebook Like Box
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_like_box_facebook')) {

	class terminus_like_box_facebook extends WP_Widget {

		private static $id_of_like_box = 0;

		function __construct() {
			$widget_ops = array( 'classname' => 'like_box_facebook', 'description' => 'Like box Facebook' ); // Widget Settings
			$control_ops = array( 'id_base' => 'like_box_facebook' ); // Widget Control Settings

			parent::__construct( 'like_box_facebook', 'Like box Facebook', $widget_ops, $control_ops ); // Create the widget
		}

		function widget($args, $instance) {
			self::$id_of_like_box++;
			extract( $args );
			$title = $instance['title'];
			$profile_id = $instance['profile_id'];
			$facebook_likebox_theme = $instance['facebook_likebox_theme'];
			$width = $instance['width'];
			$height = $instance['height'];
			$connections = $instance['connections'];
			$header = ($instance['header'] == 'yes') ? 'true' : 'false';

			// Before widget //
			echo $before_widget;

			// Title of widget //
			if ( $title ) { echo $before_title . $title . $after_title; }

			// Widget output //
			echo '<iframe id="like_box_widget_'. self::$id_of_like_box .'" src="http://www.facebook.com/plugins/likebox.php?href='. $profile_id .'&amp;colorscheme='. $facebook_likebox_theme .'&amp;width='. $width .'&amp;height='. $height .'&amp;connections='. $connections .'&amp;stream=false&amp;show_border=false&amp;header='. $header .'&amp;" scrolling="no" frameborder="0" allowTransparency="true" style="width:'. $width .'px; height:'. $height .'px;"></iframe>';

			echo $after_widget;
		}

		// Update Settings //
		function update ($new_instance, $old_instance) {
			$instance = $old_instance;

			$instance['title'] = strip_tags($new_instance['title']);
			$instance['profile_id'] = $new_instance['profile_id'];
			$instance['facebook_likebox_theme'] = $new_instance['facebook_likebox_theme'];
			$instance['width'] = $new_instance['width'];
			$instance['height'] = $new_instance['height'];
			$instance['connections'] = $new_instance['connections'];
			$instance['header'] =  $new_instance['header'];
			return $instance;
		}

		/* admin page opions */
		function form($instance) {

			$defaults = array(
				'title' => esc_html__('Like Us on Facebook', 'terminus'),
				'profile_id' => '',
				'facebook_likebox_theme' => 'light',
				'width' => '235',
				'height' => '345',
				'connections' => 10,
				'header' => 'yes'
			);
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<p class="flb_field">
				<label for="title"><?php esc_html_e('Title', 'terminus') ?>:</label><br>
				<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('title')); ?>" type="text" value="<?php echo sanitize_text_field($instance['title']); ?>" class="widefat">
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('profile_id')); ?>"><?php esc_html_e('Page ID', 'terminus') ?>:</label><br>
				<input id="<?php echo esc_attr($this->get_field_id('profile_id')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('profile_id')); ?>" type="text" value="<?php echo sanitize_text_field($instance['profile_id']); ?>" class="widefat">
			</p>

			<p>
				<label><?php esc_html_e('Facebook Like box Theme', 'terminus'); ?>:</label><br>
				<select name="<?php echo sanitize_text_field($this->get_field_name('facebook_likebox_theme')); ?>">
					<option selected="selected" value="light"><?php esc_html_e('Light', 'terminus') ?></option>
					<option value="dark"><?php esc_html_e('Dark', 'terminus') ?></option>
				</select>
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php esc_html_e('Like box Width', 'terminus') ?>:</label>
				<br>
				<input id="<?php echo esc_attr($this->get_field_id('width')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('width')); ?>" type="text" value="<?php echo sanitize_text_field($instance['width']); ?>" class="" size="3">
				<small>(<?php esc_html_e('px', 'terminus') ?>)</small>
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('height')); ?>"><?php esc_html_e("Like box Height", 'terminus') ?>:</label>
				<br>
				<input id="<?php echo esc_attr($this->get_field_id('height')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('height')); ?>" type="text" value="<?php echo sanitize_text_field($instance['height']); ?>" class="" size="3">
				<small>(<?php esc_html_e('px', 'terminus') ?>)</small>
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('connections')); ?>"><?php esc_html_e('Number of connections', 'terminus') ?>:</label>
				<br>
				<input id="<?php echo esc_attr($this->get_field_id('connections')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('connections')); ?>" type="text" value="<?php echo sanitize_text_field($instance['connections']); ?>" class="" size="3">
				<small>(<?php esc_html_e("Max. 100", 'terminus') ?>)</small>
			</p>

			<p class="flb_field">
				<label><?php esc_html_e('Show Header', 'terminus') ?>:</label><br>
				<input name="<?php echo sanitize_text_field($this->get_field_name('header')); ?>" type="radio" value="yes" <?php checked( $instance[ 'header' ], 'yes' ); ?>><?php esc_html_e("Yes", 'terminus') ?>
				<input name="<?php echo sanitize_text_field($this->get_field_name('header')); ?>" type="radio" value="no" <?php checked( $instance[ 'header' ], 'no'); ?>><?php esc_html_e("No", 'terminus') ?>
			</p>

			<?php
		}
	}

}

if (!class_exists('terminus_widget_popular_widget')) {

	class terminus_widget_popular_widget extends WP_Widget {

		public $defaults = array();
		public $version = "1.0.1";

		function __construct() {

			parent::__construct( 'popular-widget', esc_html__('Terminus Popular and Latest Posts', 'terminus'),
				array(
					'classname' => 'widget_popular_posts',
					'description' => esc_html__("Display most popular and latest posts", 'terminus')
				)
			);

			define('TERMINUS_POPWIDGET_URL', get_template_directory_uri() . '/includes/widgets/popular-widget/');
			define('TERMINUS_POPWIDGET_ABSPATH', str_replace("\\", "/", get_template_directory() . '/includes/widgets/popular-widget'));

			$this->defaults = array(
				'title' => '',
				'counter' => false,
				'excerptlength' => 5,
				'meta_key' => '_popular_views',
				'calculate' => 'visits',
				'limit' => 3,
				'thumb' => false,
				'excerpt' => false,
				'type' => 'popular'
			);

			add_action('admin_enqueue_scripts', array(&$this, 'load_admin_styles'));
			add_action('wp_enqueue_scripts', array(&$this, 'load_scripts_styles'), 1);
			add_action('wp_ajax_popwid_page_view_count', array(&$this, 'set_post_view'));
			add_action('wp_ajax_nopriv_popwid_page_view_count', array(&$this, 'set_post_view'));

		}

		function widget($args, $instance) {
			if (file_exists(TERMINUS_POPWIDGET_ABSPATH . '/inc/widget.php')) {
				include(TERMINUS_POPWIDGET_ABSPATH . '/inc/widget.php');
			}
		}

		function form($instance) {
			if (file_exists(TERMINUS_POPWIDGET_ABSPATH . '/inc/form.php')) {
				include(TERMINUS_POPWIDGET_ABSPATH . '/inc/form.php');
			}
		}

		function update($new_instance, $old_instance) {
			foreach ($new_instance as $key => $val) {
				if (is_array($val)) {
					$new_instance[$key] = $val;
				} elseif (in_array($key, array('limit', 'excerptlength'))) {
					$new_instance[$key] = intval($val);
				} elseif (in_array($key, array('calculate'))) {
					$new_instance[$key] = trim($val, ',');
				}
			}
			if (empty($new_instance['meta_key'])) {
				$new_instance['meta_key'] = $this->defaults['meta_key'];
			}
			return $new_instance;
		}

		function load_admin_styles() {
			global $pagenow;
			if ($pagenow != 'widgets.php' ) return;

			wp_enqueue_style( 'terminus_popular-admin', TERMINUS_POPWIDGET_URL . 'css/admin.css', NULL, $this->version );
			wp_enqueue_script( 'terminus_popular-admin', TERMINUS_POPWIDGET_URL . 'js/admin.js', array('jquery',), $this->version, true );
		}

		function load_scripts_styles(){

			if (! is_admin() || is_active_widget( false, false, $this->id_base, true )) {
				wp_enqueue_script( 'terminus_popular-widget', TERMINUS_POPWIDGET_URL . 'js/pop-widget.js', array('jquery'), $this->version, true);
			}

			if (! is_singular() && ! apply_filters( 'pop_allow_page_view', false )) return;

			global $post;
			wp_localize_script ( 'terminus_popular-widget', 'popwid', apply_filters( 'pop_localize_script_variables', array(
				'postid' => $post->ID
			), $post ));
		}

		function field_id($field) {
			echo $this->get_field_id($field);
		}

		function field_name($field) {
			echo $this->get_field_name($field);
		}

		function limit_words($string, $word_limit) {
			$words = explode(" ", wp_strip_all_tags(strip_shortcodes($string)));

			if ($word_limit && (str_word_count($string) > $word_limit)) {
				return $output = implode(" ",array_splice( $words, 0, $word_limit )) ."...";
			} else if( $word_limit ) {
				return $output = implode(" ", array_splice( $words, 0, $word_limit ));
			} else {
				return $string;
			}
		}

		function get_post_image($post_id, $size) {

			if (has_post_thumbnail($post_id) && function_exists('has_post_thumbnail')) {
				return get_the_post_thumbnail($post_id, $size);
			}

			$images = get_children(array(
				'order' => 'ASC',
				'numberposts' => 1,
				'orderby' => 'menu_order',
				'post_parent' => $post_id,
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
			), $post_id, $size);

			if (empty($images)) return false;

			foreach($images as $image) {
				return wp_get_attachment_image($image->ID, $size);
			}
		}

		function set_post_view() {

			if (empty($_POST['postid'])) return;
			if (!apply_filters('pop_set_post_view', true)) return;

			global $wp_registered_widgets;

			$meta_key_old = false;
			$postid = (int) $_POST['postid'];
			$widgets = get_option($this->option_name);

			foreach ((array) $widgets as $number => $widget) {
				if (!isset($wp_registered_widgets["popular-widget-{$number}"])) continue;

				$instance = $wp_registered_widgets["popular-widget-{$number}"];
				$meta_key = isset( $instance['meta_key'] ) ? $instance['meta_key'] : '_popular_views';

				if ($meta_key_old == $meta_key) continue;

				do_action( 'pop_before_set_pos_view', $instance, $number );

				if (isset($instance['calculate']) && $instance['calculate'] == 'visits') {
					if (!isset( $_COOKIE['popular_views_'.COOKIEHASH])) {
						setcookie( 'popular_views_' . COOKIEHASH, "$postid|", 0, COOKIEPATH );
						update_post_meta( $postid, $meta_key, get_post_meta( $postid, $meta_key, true ) +1 );
					} else {
						$views = explode("|", $_COOKIE['popular_views_' . COOKIEHASH]);
						foreach( $views as $post_id ){
							if( $postid == $post_id ) {
								$exist = true;  break;
							}
						}
					}
					if (empty($exist)) {
						$views[] = $postid;
						setcookie( 'popular_views_' . COOKIEHASH, implode( "|", $views ), 0 , COOKIEPATH );
						update_post_meta( $postid, $meta_key, get_post_meta( $postid, $meta_key, true ) +1 );
					}
				} else {
					update_post_meta( $postid, $meta_key, get_post_meta( $postid, $meta_key, true ) +1 );
				}
				$meta_key_old = $meta_key;
				do_action( 'pop_after_set_pos_view', $instance, $number );
			}
			die();
		}

		function get_latest_posts() {
			extract($this->instance);
			$posts = wp_cache_get("pop_latest_{$number}", 'pop_cache');

			if ($posts == false) {
				$args = array(
					'suppress_fun' => true,
					'post_type' => 'post',
					'posts_per_page' => $limit
				);
				$posts = get_posts(apply_filters('pop_get_latest_posts_args', $args));
				wp_cache_set("pop_latest_{$number}", $posts, 'pop_cache');

			}
			return $this->display_posts($posts);
		}

		function get_most_viewed() {
			extract($this->instance);
			$viewed = wp_cache_get("pop_viewed_{$number}", 'pop_cache');

			if ($viewed == false) {
				global $wpdb;  $join = $where = '';
				$viewed = $wpdb->get_results( $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS p.*, meta_value as views FROM $wpdb->posts p " .
					"JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND meta_key = %s AND meta_value != '' " .
					"WHERE 1=1 AND p.post_status = 'publish' AND post_date >= '{$this->time}' AND p.post_type IN ( 'post' )" .
					"GROUP BY p.ID ORDER BY ( meta_value+0 ) DESC LIMIT $limit", $meta_key));
				wp_cache_set( "pop_viewed_{$number}", $viewed, 'pop_cache');
			}
			return $this->display_posts($viewed);
		}

		function display_posts($posts) {

			if (empty ($posts) && !is_array($posts)) return;

			extract( $this->instance );

			ob_start(); ?>

			<?php foreach ($posts as $key => $post) :
				$commentCount = get_comments_number($post->ID);
				$link = get_permalink($post->ID);
			?>

				<li><article class="entry">

					<?php if ( !empty($thumb) ): ?>

						<?php if ( has_post_thumbnail($post->ID) ): ?>

							<?php $image = TERMINUS_HELPER::get_the_post_thumbnail($post->ID, '100*100', true, array('title' => esc_attr( $post->post_title ), 'alt' => esc_attr( $post->post_title ))); ?>

							<?php if ( isset($image) ): ?>
								<a class="entry_image" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( $post->post_title ); ?>">
									<?php echo $image; ?>
								</a>
							<?php endif; ?>

						<?php endif; ?>

					<?php endif; ?>

					<div class="entry_body">

						<ul class="byline">
							<?php
							$time_string = sprintf( '<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
								esc_attr( get_the_date( 'c', $post->ID ) ),
								get_the_date( get_option( 'date_format' ), $post->ID )
							);

							printf( '<li>%1$s </li>', $time_string ); ?>

							<?php if ( has_category('', $post->ID) ): ?>
								<li><?php echo get_the_category_list(", ", '', $post->ID) ?></li>
							<?php endif; ?>

							<?php if ( $commentCount != '0' || comments_open($post->ID)):
								$link_to = $commentCount === "0" ? "#respond" : "#comments";
								$text_add = $commentCount === "1" ? esc_html__('Comment', 'terminus' ) : esc_html__('Comments', 'terminus' ); ?>
								<li><a href='<?php echo esc_url($link . $link_to); ?>'><?php echo absint($commentCount) . ' ' . $text_add  ?></a></li>
							<?php endif; ?>

						</ul><!--/ .byline-->

						<h6 class="entry-title">
							<a href="<?php echo esc_url(get_permalink($post->ID)) ?>">
								<?php echo esc_html($post->post_title) ?>
							</a>
							<?php if (!empty($counter) && isset($post->views)): ?>
								<span>(<?php echo preg_replace( "/(?<=\d)(?=(\d{3})+(?!\d))/", ",", $post->views) ?>)</span>
							<?php endif; ?>
						</h6>

						<?php if (!empty($excerpt)): ?>
							<?php if ($post->post_excerpt): ?>
								<p class="entry-post-summary"><?php echo esc_html($this->limit_words( ( $post->post_excerpt ), $excerptlength )); ?></p>
							<?php else: ?>
								<p class="entry-post-summary"><?php echo esc_html($this->limit_words( ( $post->post_content ), $excerptlength )); ?></p>
							<?php endif; ?>
						<?php endif; ?>

					</div>

				</article></li>

			<?php endforeach; return ob_get_clean();
		}

	}
}

/*	Widget Social Links
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_widget_social_links')) {

	class terminus_widget_social_links extends Terminus_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_social_links';
			$this->widget_description =  esc_html__('Displays website social links', 'terminus');
			$this->widget_id          = 'widget-social-links';
			$this->widget_name        = esc_html__('Terminus Social Links', 'terminus');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'terminus' ),
					'std'   => esc_html__( 'Social Links', 'terminus' )
				),
				'facebook_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Facebook Link', 'terminus'),
					'std'   => esc_html__( 'http://www.facebook.com', 'terminus' )
				),
				'twitter_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Twitter Link', 'terminus'),
					'std'   => esc_html__( 'https://twitter.com', 'terminus' )
				),
				'gplus_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Google Plus Link', 'terminus'),
					'std'   => esc_html__( 'http://plus.google.com/', 'terminus' )
				),
				'pinterest_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Pinterest Link', 'terminus'),
					'std'   => esc_html__( 'https://www.pinterest.com/', 'terminus' )
				),
				'instagram_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Instagram Link', 'terminus'),
					'std'   => esc_html__( 'http://instagram.com', 'terminus' )
				),
				'linkedin_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('LinkedIn Link', 'terminus'),
					'std'   => esc_html__( 'http://linkedin.com/', 'terminus' )
				),
				'vimeo_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Vimeo Link', 'terminus'),
					'std'   => esc_html__( 'https://vimeo.com/', 'terminus' )
				),
				'youtube_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Youtube Link', 'terminus'),
					'std'   => esc_html__( 'https://youtube.com/', 'terminus' )
				),
				'flickr_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Pinterest Link', 'terminus'),
					'std'   => esc_html__( 'https://www.flickr.com/', 'terminus' )
				),
//				'vk_links'  => array(
//					'type'  => 'text',
//					'label' => esc_html__('Vkontakte Link', 'terminus'),
//					'std'   => esc_html__( 'https://www.vk.com/', 'terminus' )
//				),
//				'contact_us'  => array(
//					'type'  => 'text',
//					'label' => esc_html__('Contact us', 'terminus'),
//					'std'   => esc_html__( 'your@mail.com', 'terminus' )
//				),
			);
			parent::__construct();
		}

		function widget($args, $instance) {
			$data = array();
			$data['facebook_links'] = isset( $instance['facebook_links'] ) ? $instance['facebook_links'] : $this->settings['facebook_links']['std'];
			$data['twitter_links'] = isset( $instance['twitter_links'] ) ? $instance['twitter_links'] : $this->settings['twitter_links']['std'];
			$data['gplus_links'] = isset( $instance['gplus_links'] ) ? $instance['gplus_links'] : $this->settings['gplus_links']['std'];
			$data['pinterest_links'] = isset( $instance['pinterest_links'] ) ? $instance['pinterest_links'] : $this->settings['pinterest_links']['std'];
			$data['instagram_links'] = isset( $instance['instagram_links'] ) ? $instance['instagram_links'] : $this->settings['instagram_links']['std'];
			$data['linkedin_links'] = isset( $instance['linkedin_links'] ) ? $instance['linkedin_links'] : $this->settings['linkedin_links']['std'];
			$data['vimeo_links'] = isset( $instance['vimeo_links'] ) ? $instance['vimeo_links'] : $this->settings['vimeo_links']['std'];
			$data['youtube_links'] = isset( $instance['youtube_links'] ) ? $instance['youtube_links'] : $this->settings['youtube_links']['std'];
			$data['flickr_links'] = isset( $instance['flickr_links'] ) ? $instance['flickr_links'] : $this->settings['flickr_links']['std'];
//			$data['contact_us'] = isset( $instance['contact_us'] ) ? $instance['contact_us'] : $this->settings['contact_us']['std'];

			$this->widget_start( $args, $instance );
				echo TERMINUS_HELPER::output_widgets_html('social_links', $data);
			$this->widget_end($args);
		}

	}
}

/*	Widget Advertising Area
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_widget_advertising_area')) {

	class terminus_widget_advertising_area extends Terminus_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_advertising_area';
			$this->widget_description = esc_html__('An advertising widget that displays image', 'terminus');
			$this->widget_id          = __CLASS__;
			$this->widget_name        = esc_html__('Terminus Advertising Area', 'terminus');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Title', 'terminus' )
				),
				'image_url'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Image URL', 'terminus' )
				),
				'ref_url'  => array(
					'type'  => 'text',
					'std'   => '#',
					'label' => esc_html__( 'Referal URL', 'terminus' )
				),
			);

			parent::__construct();
		}

		function widget($args, $instance) {
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$image_url = isset( $instance['image_url'] ) ? $instance['image_url'] : $this->settings['image_url']['std'];
			$ref_url = isset( $instance['ref_url'] ) ? $instance['ref_url'] : $this->settings['ref_url']['std'];

			if ( empty($image_url) ) {
				$image_url = '<span>'.esc_html__('Advertise here', 'terminus').'</span>';
			} else {
				$image_url = '<img class="advertise-image" src="' . esc_url($image_url) . '" title="" alt=""/>';
			}

			ob_start(); ?>

			<?php $this->widget_start( $args, $instance ); ?>
				<a target="_blank" href="<?php echo esc_url($ref_url); ?>"><?php echo sprintf('%s', $image_url); ?></a>
			<?php $this->widget_end($args);

			echo ob_get_clean();
		}

	}
}

/*	Widget Contact Us
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_widget_contact_us')) {

	class terminus_widget_contact_us extends WP_Widget {

		function __construct() {
			$settings = array('classname' => 'widget_contact_us', 'description' => esc_html__('Displays contact us', 'terminus'));

			parent::__construct(__CLASS__, esc_html__('Terminus Contact Us', 'terminus'), $settings);
		}

		function widget($args, $instance) {
			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$address = empty($instance['address']) ? '' : $instance['address'];
			$phone = empty($instance['phone']) ? '' : $instance['phone'];
			$email = empty($instance['email']) ? '' : $instance['email'];
			$skype = empty($instance['skype']) ? '' : $instance['skype'];

			ob_start(); ?>

			<?php echo $before_widget; ?>

			<?php if ($title !== ''): ?>
				<?php echo $before_title . $title . $after_title; ?>
			<?php endif; ?>

			<ul class="contact_info">

				<?php if ( !empty($address) ): ?>
					<li>
						<i class="icon-location-1"></i><?php echo esc_html($address) ?>
					</li>
				<?php endif; ?>

				<?php if ( !empty($phone) ): ?>
					<li>
						<i class="icon-phone"></i><?php echo esc_html($phone) ?>
					</li>
				<?php endif; ?>

				<?php if ( !empty($email) ): ?>
					<li>
						<i class="icon-mail"></i><a target="_blank" class="over" href="mailto:<?php echo antispambot($email, 1) ?>"><?php echo esc_html($email) ?></a>
					</li>
				<?php endif; ?>

				<?php if (!empty($skype)): ?>
					<li>
						<i class="icon-skype"></i><?php echo esc_html($skype) ?>
					</li>
				<?php endif; ?>

			</ul><!--/ .c_info_list-->

			<?php echo $after_widget; ?>

			<?php echo ob_get_clean();
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			foreach($new_instance as $key => $value) {
				$instance[$key]	= strip_tags($new_instance[$key]);
			}
			return $instance;
		}

		function form($instance) {
			$defaults = array(
				'title' => esc_html__('Contact Us', 'terminus'),
				'address' => esc_html__('9870 St Vincent Place, Glasgow, DC 45 Fr 45', 'terminus'),
				'phone' => '+1 800 559 6580',
				'email' => 'info@companyname.com',
				'skype' => 'companyname'
			);
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<p>
				<label><?php esc_html_e('Title', 'terminus');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo sanitize_text_field($this->get_field_name( 'title' )); ?>" value="<?php echo sanitize_text_field($instance['title']); ?>" class="widefat" type="text" />
				</label>
			</p>

			<p>
				<label><?php esc_html_e('Address', 'terminus');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'address' )); ?>" name="<?php echo sanitize_text_field($this->get_field_name( 'address' )); ?>" value="<?php echo sanitize_text_field($instance['address']); ?>" class="widefat" type="text"/>
				</label>
			</p>

			<p>
				<label><?php esc_html_e('Phone', 'terminus');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>" name="<?php echo sanitize_text_field($this->get_field_name( 'phone' )); ?>" value="<?php echo sanitize_text_field($instance['phone']); ?>" class="widefat" type="text"/>
				</label>
			</p>

			<p>
				<label><?php esc_html_e('E-mail', 'terminus');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'email' )); ?>" name="<?php echo sanitize_text_field($this->get_field_name( 'email' )); ?>" value="<?php echo sanitize_text_field($instance['email']); ?>" class="widefat" type="text"/>
				</label>
			</p>

			<p>
				<label><?php esc_html_e('Skype', 'terminus');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'skype' )); ?>" name="<?php echo sanitize_text_field($this->get_field_name( 'skype' )); ?>" value="<?php echo sanitize_text_field($instance['skype']); ?>" class="widefat" type="text"/>
				</label>
			</p>

		<?php
		}

	}
}


/*	Widget Testimonials
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_widget_testimonials')) {

	class terminus_widget_testimonials extends Terminus_Widget {

		public $entries = '';

		public function __construct() {
			$this->widget_cssclass    = 'widget_testimonials';
			$this->widget_description = esc_html__('Use this widget to add a testimonials to your site.', 'terminus');
			$this->widget_id          = 'widget-testimonials';
			$this->widget_name        = esc_html__('Terminus Testimonials', 'terminus');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Testimonials', 'terminus' ),
					'label' => esc_html__( 'Title', 'terminus' )
				),
				'count' => array(
					'type'  => 'select',
					'std'   => '-1',
					'label' => esc_html__( 'Count', 'terminus' ),
					'options' => $this->array_number(1, 11, 1, array('-1' => 'All')),
					'desc' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'list',
					'label' => esc_html__( 'Type', 'terminus' ),
					'options' => array(
						'widgets_list' => esc_html__('List', 'terminus'),
						'widgets_carousel' => esc_html__('Carousel', 'terminus')
					),
					'desc' => esc_html__( 'How many items should be displayed per page?', 'terminus' )
				),
				'orderby' => array(
					'type'  => 'select',
					'std'   => 'date',
					'label' => esc_html__( 'Order by', 'terminus' ),
					'options' => $this->get_order_sort_array()
				)
			);

			parent::__construct();
		}

		function widget($args, $instance) {
			$count = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
			$type = isset( $instance['type'] ) ? $instance['type'] : $this->settings['type']['std'];
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];

			$query = array(
				'post_type' => 'testimonials',
				'orderby' => $orderby,
				'posts_per_page' => $count
			);

			$this->entries = new WP_Query($query);

			if (empty($this->entries) || empty($this->entries->posts)) return;

			$this->widget_start( $args, $instance ); ?>

			<div class="<?php echo esc_attr($type) ?>">

				<?php foreach ($this->entries->posts as $entry):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$place = rwmb_meta( 'terminus_tm_place', '', $id);
					?>
					<blockquote>
						<div class="author_info"><a href="<?php echo esc_url($link); ?>"><b><?php echo esc_html($name) ?>, <?php echo esc_html($place) ?></b></a></div>
						<p><?php echo sprintf('%s', $entry->post_content); ?></p>
					</blockquote>
				<?php endforeach; ?>

			</div><!--/ .widgets_carousel-->

			<footer class="bottom_box">
				<a target="_blank" href="<?php echo esc_url(get_post_type_archive_link('testimonials')); ?>" class="button_grey middle_btn">
					<?php esc_html_e('View All Testimonials', 'terminus') ?>
				</a>
			</footer><!--/ .bottom_box-->

			<?php $this->widget_end($args);
		}

		public function array_number($from = 0, $to = 50, $step = 1, $array = array()) {
			for ($i = $from; $i <= $to; $i += $step) {
				$array[$i] = $i;
			}
			return $array;
		}

		public function get_order_sort_array() {
			return array('ID' => 'ID', 'date' => 'date', 'post_date' => 'post_date', 'title' => 'title',
				'post_title' => 'post_title', 'name' => 'name', 'post_name' => 'post_name', 'modified' => 'modified',
				'post_modified' => 'post_modified', 'modified_gmt' => 'modified_gmt', 'post_modified_gmt' => 'post_modified_gmt',
				'menu_order' => 'menu_order', 'parent' => 'parent', 'post_parent' => 'post_parent',
				'rand' => 'rand', 'comment_count' => 'comment_count', 'author' => 'author', 'post_author' => 'post_author');
		}

	}
}

/*	Widget Instagram
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_instagram_widget')) {

	class terminus_instagram_widget extends TERMINUS_Widget {

		function __construct() {
			$this->widget_cssclass    = 'terminus_instagram-feed';
			$this->widget_description = esc_html__( 'Displays your latest Instagram photos', 'terminus' );
			$this->widget_id          = 'terminus_instagram-feed';
			$this->widget_name        = esc_html__('Terminus Instagram', 'terminus');
			$this->settings = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Instagram', 'terminus' ),
					'label' => esc_html__( 'Title', 'terminus' )
				),
				'username'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Username', 'terminus' )
				),
				'number'  => array(
					'type'  => 'text',
					'std'   => 9,
					'label' => esc_html__( 'Number of photos', 'terminus' )
				),
				'target' => array(
					'type'  => 'select',
					'std'   => '_self',
					'label' => esc_html__( 'Open links in', 'terminus' ),
					'options' => array(
						'_self' => esc_html__('Current window (_self)', 'terminus'),
						'_blank' => esc_html__('New window (_blank)', 'terminus')
					)
				),
				'link'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Follow Me!', 'terminus' ),
					'label' => esc_html__( 'Link text', 'terminus' )
				)
			);

			parent::__construct();
		}

		function widget( $args, $instance ) {

			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$limit = empty( $instance['number'] ) ? $this->settings['number']['std'] : $instance['number'];
			$target = empty( $instance['target'] ) ? $this->settings['target']['std'] : $instance['target'];
			$link = empty( $instance['link'] ) ? '' : $instance['link'];

			$this->widget_start( $args, $instance );

			if ( $username != '' ) {

				$media_array = $this->scrape_instagram( $username, $limit );

				if ( is_wp_error( $media_array ) ) {

					echo wp_kses_post( $media_array->get_error_message() );

				} else {

					// filter for images only?
					if ( $images_only = apply_filters( 'terminus_wpiw_images_only', FALSE ) )
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

					// filters for custom classes
					$ulclass = apply_filters( 'terminus_wpiw_list_class', 'instagram_feed' );
					$liclass = apply_filters( 'terminus_wpiw_item_class', '' );
					$aclass = apply_filters( 'terminus_wpiw_a_class', '' );
					$imgclass = apply_filters( 'terminus_wpiw_img_class', '' );

					?><ul class="<?php echo esc_attr( $ulclass ); ?>"><?php
					foreach ( $media_array as $item ) {
						echo '<li class="'. esc_attr( $liclass ) .'"><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. esc_attr( $aclass ) .'"><img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"  class="'. esc_attr( $imgclass ) .'"/></a></li>';
					}
					?></ul><?php
				}
			}

			$linkclass = apply_filters( 'terminus_link_class', 'clear' );

			if ( $link != '' ) {
				?><p class="<?php echo esc_attr( $linkclass ); ?>"><a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo wp_kses_post( $link ); ?></a></p><?php
			}

			$this->widget_end($args);
		}

		function scrape_instagram( $username, $slice = 9 ) {

			$username = strtolower( $username );
			$username = str_replace( '@', '', $username );

			if ( false === ( $instagram = get_transient( 'instagram-a3-'.sanitize_title_with_dashes( $username ) ) ) ) {

				$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

				if ( is_wp_error( $remote ) )
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'terminus' ) );

				if ( 200 != wp_remote_retrieve_response_code( $remote ) )
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'terminus' ) );

				$shards = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], TRUE );

				if ( ! $insta_array )
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'terminus' ) );

				if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				} else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'terminus' ) );
				}

				if ( ! is_array( $images ) )
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'terminus' ) );

				$instagram = array();

				foreach ( $images as $image ) {

					$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
					$image['display_src'] = preg_replace( '/^https?\:/i', '', $image['display_src'] );

					// handle both types of CDN url
					if ( (strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
						$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
						$image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
					} else {
						$urlparts = wp_parse_url( $image['thumbnail_src'] );
						$pathparts = explode( '/', $urlparts['path'] );
						array_splice( $pathparts, 3, 0, array( 's160x160' ) );
						$image['thumbnail'] = '//' . $urlparts['host'] . implode('/', $pathparts);
						$pathparts[3] = 's320x320';
						$image['small'] = '//' . $urlparts['host'] . implode('/', $pathparts);
					}

					$image['large'] = $image['thumbnail_src'];

					if ( $image['is_video'] == true ) {
						$type = 'video';
					} else {
						$type = 'image';
					}

					$caption = esc_html__( 'Instagram Image', 'terminus' );
					if ( ! empty( $image['caption'] ) ) {
						$caption = $image['caption'];
					}

					$instagram[] = array(
						'description'   => $caption,
						'link'		  	=> '//instagram.com/p/' . $image['code'],
						'time'		  	=> $image['date'],
						'comments'	  	=> $image['comments']['count'],
						'likes'		 	=> $image['likes']['count'],
						'thumbnail'	 	=> $image['thumbnail'],
						'small'			=> $image['small'],
						'large'			=> $image['large'],
						'original'		=> $image['display_src'],
						'type'		  	=> $type
					);
				}

				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $instagram ) ) {
					$instagram = serialize( $instagram );
					set_transient( 'instagram-a3-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
				}
			}

			if ( ! empty( $instagram ) ) {

				$instagram = unserialize( $instagram );
				return array_slice( $instagram, 0, $slice );

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'terminus' ) );

			}
		}

		function images_only( $media_item ) {
			if ( $media_item['type'] == 'image' )
				return true;

			return false;
		}
	}

}

/*	Widget Flickr
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_widget_flickr')) {

	class terminus_widget_flickr extends WP_Widget {

		function __construct() {
			$settings = array('classname' => 'widget_flickr', 'description' => esc_html__('Flickr feed widget', 'terminus'));
			parent::__construct(__CLASS__,  esc_html__('Terminus Flickr feed', 'terminus'), $settings);
		}

		function widget($args, $instance) {
			extract($args, EXTR_SKIP);

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$unique_id = rand(0, 300);

			echo $before_widget;

			if ($title !== '') {
				echo $before_title . $title . $after_title;
			}

			?>

			<ul id="flickr_feed_<?php echo absint($unique_id) ?>" class="flickr_feed"></ul>

			<script type="text/javascript">
				jQuery(function () {
					jQuery('#flickr_feed_<?php echo absint($unique_id) ?>').jflickrfeed({
						limit: <?php echo absint($instance['imagescount']) ?>,
						qstrings: { id: '<?php echo sprintf('%s', $instance['username']) ?>' },
						itemTemplate: '<li><a class="fancybox" target="_blank" href="{{image_b}}"><img width="100" height="100" src="{{image_s}}" alt="{{title}}" /></a></li>'
					}, function() {
						jQuery(this).find('.fancybox').fancybox();
					});
				});
			</script>

			<?php echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['imagescount'] = (int) $new_instance['imagescount'];
			return $instance;
		}

		function form($instance) {
			$defaults = array(
				'title' => 'Flickr Feed',
				'username' => '76745153@N04',
				'imagescount' => '8',
			);
			$instance = wp_parse_args((array) $instance, $defaults); ?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'terminus') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('title')); ?>" value="<?php echo sanitize_text_field($instance['title']); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php esc_html_e('Flickr Username', 'terminus') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('username')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('username')); ?>" value="<?php echo sanitize_text_field($instance['username']); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('imagescount')); ?>"><?php esc_html_e('Number of images', 'terminus') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('imagescount')); ?>" name="<?php echo sanitize_text_field($this->get_field_name('imagescount')); ?>" value="<?php echo sanitize_text_field($instance['imagescount']) ?>" />
			</p>

		<?php
		}

	}
}

/*	Widget Dribbble
/* ----------------------------------------------------------------- */

if (!class_exists('terminus_dribbble_widget')) {

	class terminus_dribbble_widget extends TERMINUS_Widget {

		function __construct() {
			$this->widget_cssclass    = 'terminus_dribbble';
			$this->widget_description = esc_html__( 'Displays your latest Dribbble photos', 'terminus' );
			$this->widget_id          = 'terminus_dribbble';
			$this->widget_name        = esc_html__('Terminus Dribbble', 'terminus');
			$this->settings = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Dribbble Feed', 'terminus' ),
					'label' => esc_html__( 'Title', 'terminus' )
				),
				'access'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Set your dribbble client access token', 'terminus' )
				),
				'shots' => array(
					'type'  => 'select',
					'std'   => 'animated',
					'label' => esc_html__( 'The types of shot lists that are available through the API', 'terminus' ),
					'options' => array(
						'animated' => esc_html__('animated', 'terminus'),
						'attachments' => esc_html__('attachments', 'terminus'),
						'debuts' => esc_html__('debuts', 'terminus'),
						'playoffs' => esc_html__('playoffs', 'terminus'),
						'rebounds' => esc_html__('rebounds', 'terminus'),
						'teams' => esc_html__('teams', 'terminus')
					)
				),
				'number'  => array(
					'type'  => 'text',
					'std'   => 4,
					'label' => esc_html__( 'Number of photos', 'terminus' )
				)
			);

			parent::__construct();
		}

		function widget( $args, $instance ) {

			$access = empty( $instance['access'] ) ? '' : $instance['access'];
			$shots = empty( $instance['shots'] ) ? $this->settings['shots']['std'] : $instance['shots'];
			$limit = empty( $instance['number'] ) ? $this->settings['number']['std'] : $instance['number'];

			$this->widget_start( $args, $instance );

			if ( $access != '' ) {
				$rand = rand(0, 100);
				$gallery_class = 'terminus_dribbble_' . absint($rand);
				?><ul class="dribbble_feed" data-access-token="<?php echo esc_attr($access) ?>" data-shots="<?php echo esc_attr($shots) ?>" data-per-page="<?php echo esc_attr($limit) ?>" data-dribbble-gallery="<?php echo esc_attr($gallery_class) ?>"></ul><?php
			}

			$this->widget_end($args);

		}

	}

}

add_action('widgets_init', create_function('', 'return register_widget("terminus_widget_popular_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_widget_social_links");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_widget_advertising_area");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_widget_contact_us");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_widget_testimonials");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_instagram_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_dribbble_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_widget_flickr");'));
add_action('widgets_init', create_function('', 'return register_widget("terminus_like_box_facebook");'));

?>