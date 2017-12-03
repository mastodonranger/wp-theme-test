<?php
if (!class_exists('terminus_image_video_gallery')) {

	class terminus_image_video_gallery {

		function __construct() {
			add_action('vc_before_init', array($this, 'add_map_image_video_gallery'));
		}
		
		function add_map_image_video_gallery() {

			$terminus_target_arr = array(
				esc_html__( 'Same window', 'terminus' ) => '_self',
				esc_html__( 'New window', 'terminus' ) => "_blank"
			);

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
					   "name" => esc_html__("Image / Video Gallery", 'terminus' ),
					   "base" => "vc_mad_image_video_gallery",
					   "class" => "vc_mad_image_video_gallery",
					   "icon" => "icon-wpb-mad-image-gallery",
						'category' => esc_html__( 'Terminus', 'terminus' ),
					   "description" => esc_html__('Responsive image/video gallery', 'terminus'),
					   "as_parent" => array('only' => 'vc_mad_image_gallery_item,vc_mad_video_gallery_item'),
					   "content_element" => true,
					   "show_settings_on_create" => false,
					   "params" => array(
						   array(
							   'type' => 'textfield',
							   'heading' => esc_html__( 'Widget title', 'terminus' ),
							   'param_name' => 'title',
							   'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'terminus' )
						   ),
						   array(
							   'type' => 'checkbox',
							   'heading' => esc_html__( 'Autoplay', 'terminus' ),
							   'param_name' => 'autoplay',
							   'description' => esc_html__( 'Enables autoplay mode.', 'terminus' ),
							   'value' => array( esc_html__( 'Yes, please', 'terminus' ) => 'yes' )
						   ),
						   array(
							   'type' => 'number',
							   'heading' => esc_html__( 'Autoplay timeout', 'terminus' ),
							   'param_name' => 'autoplaytimeout',
							   'description' => esc_html__( 'Autoplay interval timeout.', 'terminus' ),
							   'value' => 4000,
							   'dependency' => array(
								   'element' => 'autoplay',
								   'value' => 'yes'
							   )
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Number of items', 'terminus' ),
							   'param_name' => 'items',
							   'value' => array(
								   1 => 1,
								   2 => 2,
								   3 => 3,
								   4 => 4
							   ),
							   'description' => esc_html__( 'The number of items you want to see on the screen.', 'terminus' )
						   )
						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
					   "name" => esc_html__("Image Gallery Item", 'terminus'),
					   "base" => "vc_mad_image_gallery_item",
					   "class" => "vc_mad_image_gallery_item",
					   "icon" => "icon-wpb-images-stack",
					   "category" => esc_html__('Image / Video Gallery', 'terminus'),
					   "content_element" => true,
					   "as_child" => array('only' => 'vc_mad_image_video_gallery'),
					   "is_container" => false,
					   "params" => array(
							array(
								'type' => 'attach_image',
								'heading' => esc_html__( 'Image', 'terminus' ),
								'param_name' => 'image',
								'value' => '',
								'description' => esc_html__( 'Select image from media library.', 'terminus' )
							),
						   array(
							   'type' => 'textfield',
							   'heading' => esc_html__( 'Dimensions', 'terminus' ),
							   'param_name' => 'dimensions',
							   "value" => '750*500',
							   'description' => esc_html__('Enter image size in pixels: 750*500 (Width * Height). Leave empty to use full size.', 'terminus' )
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'On click', 'terminus' ),
							   'param_name' => 'onclick',
							   'value' => array(
								   esc_html__( 'Open Lightbox', 'terminus' ) => 'link_image',
								   esc_html__( 'Do nothing', 'terminus' ) => 'link_no',
								   esc_html__( 'Open custom link', 'terminus' ) => 'custom_link'
							   ),
							   'description' => esc_html__( 'Define action for onclick event if needed.', 'terminus' )
						   ),
						   array(
							   'type' => 'exploded_textarea',
							   'heading' => esc_html__( 'Custom link', 'terminus' ),
							   'param_name' => 'custom_link',
							   'description' => esc_html__('Enter link.', 'terminus' ),
							   'dependency' => array(
								   'element' => 'onclick',
								   'value' => array( 'custom_link' )
							   )
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Custom link target', 'terminus' ),
							   'param_name' => 'custom_link_target',
							   'description' => esc_html__( 'Select where to open custom link.', 'terminus' ),
							   'dependency' => array(
								   'element' => 'onclick',
								   'value' => array( 'custom_link' )
							   ),
							   'value' => $terminus_target_arr
						   )
					    )
					)
				);

				vc_map(
					array(
						"name" => esc_html__("Video Gallery Item", 'terminus'),
						"base" => "vc_mad_video_gallery_item",
						"class" => "vc_mad_video_gallery_item",
						"icon" => "icon-wpb-images-stack",
						"category" => esc_html__('Image / Video Gallery', 'terminus'),
						"content_element" => true,
						"as_child" => array('only' => 'vc_mad_image_video_gallery'),
						"is_container" => false,
						"params" => array(
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Video link', 'terminus' ),
								'param_name' => 'video_link',
								'description' => esc_html__('Straight URL from youtube or vimeo.', 'terminus' )
							)
						)
					)
				);

			}
		}

	}

	if (class_exists('WPBakeryShortCodesContainer')) {

		class WPBakeryShortCode_vc_mad_image_video_gallery extends WPBakeryShortCodesContainer {

			protected function content($atts, $content = null) {

				$title = $autoplay = $autoplaytimeout = $items = '';

				extract(shortcode_atts(array(
					'title' => '',
					'autoplay' => 0,
					'autoplaytimeout' => 4000,
					'items' => 1
				), $atts));

				global $set;
				$set = $dimensions = $checkValues = array();

				do_shortcode( $content );

				foreach ( $set as $value => $key) {
					$dimensions[] = $key['dimensions'];
				}

				$checkValues = array_flip($dimensions);

				$data_attributes = array(
					'autoplay' => $autoplay,
					'autoplaytimeout' => $autoplaytimeout,
					'items' => $items
				);

				if ( count($checkValues) > 1 ) {
					$data_attributes['autowidth'] = true;
				}

				$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'slideshow', $atts );

				if ( empty($content) ) return;

				ob_start(); ?>

				<?php if ( !empty($title) ): ?>

					<?php echo Terminus_Vc_Config::getParamTitle($title); ?>

				<?php endif; ?>

				<div <?php echo TERMINUS_HELPER::create_data_string($data_attributes)?> class="<?php echo esc_attr($css_class) ?>"><?php echo wpb_js_remove_wpautop($content, false) ?></div>

				<?php return ob_get_clean() ;
			}

		}

		class WPBakeryShortCode_vc_mad_image_gallery_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {

				$image = $dimensions = $onclick = $custom_link = $custom_link_target = $alt = '';

				extract(shortcode_atts(array(
					'image' => '',
					'dimensions' => '750*500',
					'onclick' => 'link_image',
					'custom_link' => '',
					'custom_link_target' => ''
				),$atts));

				global $set;

				$set[] = array (
					'dimensions' => $dimensions
				);

				ob_start(); ?>

				<?php if (isset($image) && $image > 0):
				$post_thumbnail = array();
				$alt = trim(strip_tags(get_post_meta($image, '_wp_attachment_image_alt', true)));
				$full_image = TERMINUS_HELPER::get_post_attachment_image($image, '');
				$post_thumbnail['p_img_large'] = TERMINUS_HELPER::get_post_attachment_image($image, $dimensions);
				$p_img_large = $post_thumbnail['p_img_large'];
				?>

					<div class="slide-item item-image">

						<?php if ( $onclick == 'link_image' ): ?>

							<a data-fancybox-group="group" class="fancybox" href="<?php echo esc_url($full_image) ?>"><img src="<?php echo esc_attr($p_img_large) ?>" alt="<?php echo esc_attr($alt) ?>"></a>

						<?php elseif( $onclick == 'link_no' ): ?>

							<img src="<?php echo esc_attr($p_img_large) ?>" alt="<?php echo esc_attr($alt) ?>">

						<?php elseif ( $onclick == 'custom_link' && isset($custom_link) && $custom_link != '' ): ?>

							<a href="<?php echo esc_url($custom_link); ?>" <?php echo (!empty($custom_link_target) ? ' target="' . esc_attr($custom_link_target) . '"' : '' ) ?>>
								<img src="<?php echo esc_attr($p_img_large) ?>" alt="<?php echo esc_attr($alt) ?>">
							</a>

						<?php endif; ?>

					</div>

				<?php endif; ?>

				<?php return ob_get_clean() ;

			}

		}

		class WPBakeryShortCode_vc_mad_video_gallery_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {
				$video_link = '';

				extract(shortcode_atts(array(
					'video_link' => '',
				),$atts));

				$video_service = $this->which_video_service($video_link);

				ob_start(); ?>

				<?php if ( !empty($video_service) ): ?>

					<div class="slide-item item-video">
						<div class="iframe_wrap">
							<iframe src="<?php echo esc_url($video_link) ?>"></iframe>
						</div>
					</div>

				<?php endif; ?>

				<?php return ob_get_clean() ;
			}

			public function which_video_service($video_url) {
				$service = "";

				if ( strpos($video_url, 'youtube.com/embed') !== false || strpos($video_url, 'youtu.be/') !== false ) {
					$service = "youtube";
				} else if ( strpos($video_url, 'vimeo.com') !== false ) {
					$service = "vimeo";
				} else if ( strpos($video_url, 'maps.google.com') !== false ) {
					$service = "google";
				}

				return $service;
			}

		}
	}

	new terminus_image_video_gallery();
}