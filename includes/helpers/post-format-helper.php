<?php

// -----------------------  Single Format ------------------------- //

add_filter( 'terminus-entry-format-single', 'terminus_single_post_filter', 11, 1 );

// ----------------------- Standard Post Format ------------------------- //

add_filter( 'terminus-entry-format-standard', 'terminus_standard_post_filter', 11, 1 );

// ------------------------ Gallery Post Format ------------------------- //

add_filter( 'terminus-entry-format-gallery', 'terminus_gallery_post_filter', 11, 1 );

// ------------------------- Video Post Format -------------------------- //

add_filter( 'terminus-entry-format-video', 'terminus_video_post_filter', 11, 1 );

// ------------------------- Audio Post Format -------------------------- //

add_filter( 'terminus-entry-format-audio', 'terminus_audio_post_filter', 11, 1 );

// ------------------------- Quote Post Format -------------------------- //

add_filter( 'terminus-entry-format-quote', 'terminus_quote_post_filter', 11, 1 );

// ------------------------- Link Post Format -------------------------- //

add_filter( 'terminus-entry-format-link', 'terminus_link_post_filter', 11, 1 );

//  Single Post Filter									//
// ==================================================== //

if (!function_exists('terminus_single_post_filter')) {

	function terminus_single_post_filter ($this_post) {

		$format = $this_post['post_format'];

		switch ($format) {

			case 'gallery':

				preg_match("!\[(?:)?gallery.+?\]!", $this_post['content'], $match_gallery);

				if ( !empty($match_gallery) ) {

					$gallery = $match_gallery[0];

					if ( strpos($gallery, 'vc_') === false ) {
						$gallery = str_replace("gallery", 'terminus_post_gallery post_id="'. esc_attr($this_post['post_id']) .'"', $gallery);
					}

					$this_post['before_content'] = do_shortcode($gallery);
					$this_post['content'] = str_replace($match_gallery[0], '', $this_post['content']);
					$this_post['content'] = apply_filters('the_content', $this_post['content']);
				}

				break;

			case 'audio':

				preg_match("!\[audio.+?\]\[\/audio\]!", $this_post['content'], $match_audio);
				preg_match("!\[embed.+?\]!", $this_post['content'], $match_embed);

				if ( !empty($match_embed) && strpos($match_embed[0], 'soundcloud.com') !== false ) {
					global $wp_embed;
					$embed = $match_embed[0];
					$embed = str_replace("[embed", '[embed height="120"', $embed);

					$this_post['before_content'] = do_shortcode($wp_embed->run_shortcode($embed));
					$this_post['content'] = str_replace($match_embed[0], "", $this_post['content']);
					$this_post['content'] = apply_filters('the_content', $this_post['content']);
				} else if ( !empty($match_audio) ) {
					$this_post['before_content'] = do_shortcode($match_audio[0]);
					$this_post['content'] = str_replace($match_audio[0], "", $this_post['content']);
					$this_post['content'] = apply_filters('the_content', $this_post['content']);
				}

				break;
			case 'video':

				preg_match("!\[embed.+?\]|\[video.+?\]!", $this_post['content'], $match_video);

				if ( !empty($match_video) ) {
					global $wp_embed;
					$video = $match_video[0];
					$this_post['before_content'] = "<div class='iframe_wrap'>";
					$this_post['before_content'] .= do_shortcode($wp_embed->run_shortcode($video));
					$this_post['before_content'] .= "</div>";
					$this_post['content'] = str_replace($match_video[0], "", $this_post['content']);
					$this_post['content'] = apply_filters('the_content', $this_post['content']);
				} else {

					preg_match("!\[(?:)?vc_video.+?\]!", $this_post['content'], $match_video);

					if (!empty($match_video)) {
						$video = $match_video[0];
						$this_post['before_content'] = do_shortcode($video);
						$this_post['content'] = str_replace($match_video[0], "", $this_post['content']);
						$this_post['content'] = apply_filters('the_content', $this_post['content']);
					}

				}

				break;

			case 'quote':

				preg_match('~<blockquote\b[^>]*>(?:[^<]+|(?R)|<(?!/(?:blockquote|p)>))*</blockquote>~', $this_post['content'], $match_quote);

				if (!empty($match_quote)) {
					$quote = $match_quote[0];
					$this_post['before_content'] = '<div class="post-quote">'. do_shortcode($quote) .'</div>';
					$this_post['content'] = str_replace($match_quote[0], "", $this_post['content']);
					$this_post['content'] = apply_filters('the_content', $this_post['content']);
				}

				break;
			case 'link':

				$link 		= "";

				$pattern1 	= '$^\b(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]$i';
				$pattern2 	= "!^\<a.+?<\/a>!";
				$pattern3 	= "!\<a.+?<\/a>!";

				preg_match($pattern1, $this_post['content'] , $link);

				if ( !empty($link[0]) ) {
					$link = $link[0];
					$this_post['content'] = preg_replace("!".str_replace("?", "\?", $link)."!", "", $this_post['content'], 1);
				} else {

					preg_match($pattern2, $this_post['content'] , $link);

					if ( !empty($link[0]) ) {
						$link = $link[0];
						$this_post['content'] = preg_replace("!".str_replace("?", "\?", $link)."!", "", $this_post['content'], 1);
					} else {

						preg_match($pattern3,  $this_post['content'] , $link);

						if ( !empty($link[0]) ) {
							$link = $link[0];
						}
					}

				}

				if ( $link ) {

					if (is_array($link)) $link = $link[0];

					$this_post['before_content'] = "<div class='link_container'><span class='si-icon si-icon-link'></span>{$link}</div>";
					$this_post['content'] = str_replace($link, "", $this_post['content']);
					$this_post['content'] = apply_filters('the_content', $this_post['content']);
				}

				break;
			default:
				$this_post['content'] = apply_filters('the_content', $this_post['content']);
				break;
		}


		return $this_post;
	}
}

//  Standard Filter										//
// ==================================================== //

if (!function_exists('terminus_standard_post_filter')) {

	function terminus_standard_post_filter($this_post) {
		$before = '';
		$this_id = $this_post['post_id'];
		$image_size = $this_post['image_size'];

		$thumbnail_atts = array(
			'alt'	=> trim(strip_tags(get_the_excerpt())),
			'title'	=> trim(strip_tags(get_the_title()))
		);

		if ( is_single() ) {
			$link = TERMINUS_HELPER::get_post_featured_image($this_id, '');
		} else {
			$link = $this_post['url'];
		}

		$link = esc_url($link);

		if ( has_post_thumbnail($this_id) ) {
			$thumbnail = TERMINUS_HELPER::get_the_post_thumbnail( $this_id, $image_size, true, $thumbnail_atts );
			$img_link = TERMINUS_HELPER::get_post_featured_image( $this_id, '' );

			$before = '<div class="image-content">';
				$before .= $thumbnail;
				$before .= '<div class="image-hover">';
					$before .= '<div class="image-extra">';
						$before .= "<a href='{$img_link}' class='curtain-overlay overlay-type-image'></a>";
						$before .= "<a href='{$link}' title='". sprintf(esc_attr__('%s', 'terminus'), get_the_title($this_id)) ."' class='curtain-overlay overlay-type-link'></a>";
					$before .= '</div>';
				$before .= '</div>';
			$before .= '</div>';
		}

		if ( is_string($before) && !empty($before) ) {
			$this_post['before_content'] = $before;
		}
		return $this_post;
	}
}

//  Gallery Post Filter									//
// ==================================================== //

if (!function_exists('terminus_gallery_post_filter')) {

	function terminus_gallery_post_filter ($this_post) {
		preg_match("!\[(?:)?gallery.+?\]!", $this_post['content'], $match_gallery);

		if ( !empty($match_gallery) ) {
			$gallery = $match_gallery[0];
            if (strpos($gallery, 'vc_') === false) {
				$gallery = str_replace("gallery", 'terminus_post_gallery image_size="'. esc_attr($this_post['image_size']) .'" post_id="'. esc_attr($this_post['post_id']) .'"', $gallery);
			}
            $this_post['before_content'] = do_shortcode($gallery);
			$this_post['content'] = str_replace( $match_gallery[0], '', $this_post['content'] );
			$this_post['content'] = apply_filters( 'the_content', $this_post['content'] );
		}
		return $this_post;
	}
}

//  Audio Post Filter									//
// ==================================================== //

if (!function_exists('terminus_audio_post_filter')) {

	function terminus_audio_post_filter($this_post) {
		$this_post['content'] = preg_replace( '|^\s*(http?://[^\s"]+)\s*$|im', "[audio src='$1']", strip_tags($this_post['content']) );

		preg_match("!\[audio.+?\]\[\/audio\]!", $this_post['content'], $match_audio);
		preg_match("!\[embed.+?\]!", $this_post['content'], $match_embed);

		if ( !empty($match_embed) && strpos($match_embed[0], 'soundcloud.com') !== false ) {
			global $wp_embed;
			$alias = $this_post['image_size'];
			$embed = $match_embed[0];
			$embed = str_replace('[embed]', '[embed width="'. $alias[0] .'" height="120"]', $embed);
			$this_post['before_content'] = $wp_embed->run_shortcode($embed);
			$this_post['content'] = str_replace($match_embed[0], "", $this_post['content']);
			return $this_post;
		} else if (!empty($match_audio)) {
			$this_post['before_content'] = do_shortcode($match_audio[0]);
			$this_post['content'] = str_replace($match_audio[0], "", $this_post['content']);
		}
		$this_post['content'] = apply_filters('the_content', $this_post['content']);
		return $this_post;
	}
}

//  Video Post Filter									//
// ==================================================== //

if (!function_exists('terminus_video_post_filter')) {

	function terminus_video_post_filter($this_post) {
		$this_post['content'] = preg_replace( '|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", strip_tags($this_post['content']));
		preg_match("!\[embed.+?\]|\[video.+?\]!", $this_post['content'], $match_video);

		if ( !empty($match_video) ) {
			global $wp_embed;

			$video = $match_video[0];

			$this_post['before_content'] = "<div class='iframe_wrap'>";
				$this_post['before_content'] .= do_shortcode($wp_embed->run_shortcode($video));
			$this_post['before_content'] .= "</div>";
			$this_post['content'] = str_replace($match_video[0], "", $this_post['content']);
			$this_post['content'] = apply_filters('the_content', $this_post['content']);
		} else {

			preg_match("!\[(?:)?vc_video.+?\]!", $this_post['content'], $match_video);

			if (!empty($match_video)) {
				$video = $match_video[0];
				$this_post['before_content'] = do_shortcode($video);
				$this_post['content'] = str_replace($match_video[0], "", $this_post['content']);
				$this_post['content'] = apply_filters('the_content', $this_post['content']);
			}

		}
		return $this_post;
	}
}

//  Quote Post Filter									//
// ==================================================== //

if (!function_exists('terminus_quote_post_filter')) {

	function terminus_quote_post_filter($this_post) {

		preg_match('~<blockquote\b[^>]*>(?:[^<]+|(?R)|<(?!/(?:blockquote|p)>))*</blockquote>~', $this_post['content'], $match_quote);
		preg_match('~\[vc_mad_blockquotes([^\[\]]*)]([^\[\]]+)\[/vc_mad_blockquotes]~', $this_post['content'], $matches);

		if ( !empty($match_quote) ) {
			$quote = $match_quote[0];
			$this_post['before_content'] = '<div class="post-quote"><a href="'. esc_url($this_post['url']) .'" class="whole-link"></a>'. do_shortcode($quote) .'</div>';
			$this_post['content'] = str_replace($match_quote[0], "", $this_post['content']);
		} elseif ( !empty($matches[2])) {
			$quote = $matches[2];
			$this_post['before_content'] = '<div class="post-quote"><a href="'. esc_url($this_post['url']) .'" class="whole-link"></a><blockquote>'. do_shortcode($quote) .'</blockquote></div>';
		}

		$this_post['content'] = apply_filters('the_content', $this_post['content']);
		return $this_post;
	}
}

//  Link Post Filter									//
// ==================================================== //

if(!function_exists('terminus_link_post_filter')) {
	function terminus_link_post_filter($this_post) {
		$link 		= "";

		$pattern1 	= '$^\b(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]$i';
		$pattern2 	= "!^\<a.+?<\/a>!";
		$pattern3 	= "!\<a.+?<\/a>!";

		preg_match($pattern1, $this_post['content'] , $link);

		if ( !empty($link[0]) ) {
			$link = $link[0];
			$this_post['content'] = preg_replace("!".str_replace("?", "\?", $link)."!", "", $this_post['content'], 1);
		} else {

			preg_match($pattern2, $this_post['content'] , $link);

			if ( !empty($link[0]) ) {
				$link = $link[0];
				$this_post['content'] = preg_replace("!".str_replace("?", "\?", $link)."!", "", $this_post['content'], 1);
			} else {

				preg_match($pattern3,  $this_post['content'] , $link);

				if ( !empty($link[0]) ) {
					$link = $link[0];
				}
			}

		}

		if ( $link ) {

			if (is_array($link)) $link = $link[0];

			$this_post['before_content'] = "<div class='link_container'><span class='si-icon si-icon-link'></span>{$link}</div>";

		}

		return $this_post;
	}
}