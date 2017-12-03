<?php

/*	String Truncate
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_string_truncate')) {
	function terminus_string_truncate($string, $limit, $break=".", $pad="...", $stripClean = false, $excludetags = '<strong><em><span>', $safe_truncate = false) {
		if ( $stripClean ) {
			$string = strip_shortcodes(wp_strip_all_tags($string, $excludetags));
		}

		if ( strlen($string) <= $limit ) return $string;

		if ( false !== ($breakpoint = strpos($string, $break, $limit)) ) {
			if ($breakpoint < strlen($string) - 1) {
				if ($safe_truncate || is_rtl()) {
					$string = mb_strimwidth($string, 0, $breakpoint) . $pad;
				} else {
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
		}

		// if there is no breakpoint an no tags we could accidentaly split split inside a word
		if ( !$breakpoint && strlen(strip_tags($string)) == strlen($string) ) {
			if ( $safe_truncate || is_rtl() ) {
				$string = mb_strimwidth($string, 0, $limit) . $pad;
			} else {
				$string = substr($string, 0, $limit) . $pad;
			}
		}

		return $string;
	}
}

/*	Get Site Icon
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_get_site_icon_url')) {

	function terminus_get_site_icon_url( $size = 512, $url = '' ) {

		$site_icon_id = terminus_get_option("favicon_upload");

		if ( $site_icon_id ) {
			if ( $size >= 512 ) {
				$size_data = 'full';
			} else {
				$size_data = array( $size, $size );
			}
			$url_data = wp_get_attachment_image_src( $site_icon_id, $size_data );
			if ( $url_data ) {
				$url = $url_data[0];
			}
		}

		return $url;
	}
}

/*	Site Icon
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_wp_site_icon')) {

	function terminus_wp_site_icon() {

		$favicon = terminus_get_option("favicon_upload");
		if ( ! $favicon ) { return; }

		$meta_tags = array(
			sprintf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( terminus_get_site_icon_url( 32 ) ) ),
			sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( terminus_get_site_icon_url( 192 ) ) ),
			sprintf( '<link rel="apple-touch-icon-precomposed" href="%s">', esc_url( terminus_get_site_icon_url( 180 ) ) ),
			sprintf( '<meta name="msapplication-TileImage" content="%s">', esc_url( terminus_get_site_icon_url( 270 ) ) ),
		);

		$meta_tags = array_filter( $meta_tags );

		foreach ( $meta_tags as $meta_tag ) {
			echo "$meta_tag\n";
		}

	}
}

/*	Blog Post Meta
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_blog_post_meta') ) {

	function terminus_blog_post_meta($id = 0) {

		$commentCount = get_comments_number($id);
		$link = get_permalink($id);

		ob_start(); ?>

		<?php if ( is_single() ): ?>

			<ul class="byline">

				<?php if ( is_sticky($id) ): ?>
					<?php printf( '<li><span class="sticky-post">%s</span></li>', esc_html__( 'Featured', 'terminus' ) ); ?>
				<?php endif; ?>

				<?php if ( in_array( get_post_type($id), array( 'post', 'attachment' ) ) ): ?>
					<?php if ( terminus_get_option('blog-single-meta-date') ): ?>
						<?php echo terminus_entry_date($id); ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( terminus_get_option('blog-single-meta-author') ): ?>
					<li><?php echo the_author_posts_link(); ?></li>
				<?php endif; ?>

				<?php if ( terminus_get_option('blog-single-meta-category') ): ?>
					<?php if ( has_category('', $id) ): ?>
						<li><?php echo get_the_category_list(", ", '', $id) ?></li>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( terminus_get_option('blog-single-meta-tags') ): ?>
					<?php if ( has_tag('', $id) ): ?>
						<li><?php echo get_the_tag_list('', ', ', '', $id); ?></li>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( terminus_get_option('blog-single-meta-comment') ): ?>
					<?php if ( $commentCount != '0' || comments_open($id)):
						$link_to = $commentCount === "0" ? "#respond" : "#comments";
						$text_add = $commentCount === "1" ? esc_html__('Comment', 'terminus' ) : esc_html__('Comments', 'terminus' ); ?>
						<li><a href='<?php echo esc_url($link . $link_to); ?>'><?php echo absint($commentCount) . ' ' . $text_add  ?></a></li>
					<?php endif; ?>
				<?php endif; ?>

			</ul><!--/ .byline-->

		<?php else: ?>

			<ul class="byline">

				<?php if ( is_sticky($id) ): ?>
					<?php printf( '<li><span class="sticky-post">%s</span></li>', esc_html__( 'Featured', 'terminus' ) ); ?>
				<?php endif; ?>

				<?php if ( in_array( get_post_type($id), array( 'post', 'attachment' ) ) ): ?>
					<?php if ( terminus_get_option('blog-listing-meta-date') ): ?>
						<?php echo terminus_entry_date($id); ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( terminus_get_option('blog-listing-meta-category') ): ?>
					<?php if ( has_category('', $id) ): ?>
						<li><?php echo get_the_category_list(", ", '', $id) ?></li>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( terminus_get_option('blog-listing-meta-comment') ): ?>

					<?php if ( $commentCount != '0' || comments_open($id)):
						$link_to = $commentCount === "0" ? "#respond" : "#comments";
						$text_add = $commentCount === "1" ? esc_html__('Comment', 'terminus' ) : esc_html__('Comments', 'terminus' ); ?>
						<li><a href='<?php echo esc_url($link . $link_to); ?>'><?php echo absint($commentCount) . ' ' . $text_add  ?></a></li>
					<?php endif; ?>

				<?php endif; ?>

			</ul><!--/ .byline-->

		<?php endif; ?>

		<?php return ob_get_clean();
	}
}

/* 	Regex
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_regex')) {

	/*
	*	Regex for url: http://mathiasbynens.be/demo/url-regex
	*/
	function terminus_regex($string, $pattern = false, $start = "^", $end = "") {
		if (!$pattern) return false;

		if ($pattern == "url") {
			$pattern = "!$start((https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?)$end!";
		} else if ($pattern == "link") {
			$pattern = '/(((http|ftp|https):\/{2})+(([0-9a-z_-]+\.)+(aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mn|mn|mo|mp|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|nom|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ra|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw|arpa)(:[0-9]+)?((\/([~0-9a-zA-Z\#\+\%@\.\/_-]+))?(\?[0-9a-zA-Z\+\%@\/&\[\];=_-]+)?)?))\b/imuS';
		} else if ($pattern == "mail") {
			$pattern = "!$start\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$end!";
		} else if ($pattern == "image") {
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))$end!";
		} else if ($pattern == "mp4") {
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:mp4)))$end!";
		} else if (strpos($pattern,"<") === 0) {
			$pattern = str_replace('<',"",$pattern);
			$pattern = str_replace('>',"",$pattern);

			if (strpos($pattern,"/") !== 0) { $close = "\/>"; $pattern = str_replace('/',"",$pattern); }
			$pattern = trim($pattern);
			if (!isset($close)) $close = "<\/".$pattern.">";

			$pattern = "!$start\<$pattern.+?$close!";
		}

		preg_match($pattern, $string, $result);

		if (empty($result[0])) {
			return false;
		} else {
			return $result;
		}
	}
}

/*	Tag Archive Page
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_tag_archive_page')) {

	function terminus_tag_archive_page($query) {
		$post_types = get_post_types();

		if (is_category() || is_tag()) {
			if (!is_admin() && $query->is_main_query()) {

				$post_type = get_query_var(get_post_type());

				if ($post_type) {
					$post_type = $post_type;
				} else {
					$post_type = $post_types;
				}
				$query->set('post_type', $post_type);
			}
		}
		return $query;
	}
	add_filter('pre_get_posts', 'terminus_tag_archive_page');
}

/* 	Filter Hook for Comments
/* --------------------------------------------------------------------- */

if ( !function_exists('terminus_output_comments')) {

	function terminus_output_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>

		<li class="comment" id="comment-<?php echo comment_ID() ?>">

			<article>

				<!-- - - - - - - - - - - - - - Avatar - - - - - - - - - - - - - - - - -->

				<div class="gravatar">
					<?php echo get_avatar($comment, 100, '', esc_html(get_comment_author())); ?>
				</div>

				<!-- - - - - - - - - - - - - - End of avatar - - - - - - - - - - - - - - - - -->

				<!-- - - - - - - - - - - - - - Comment Body - - - - - - - - - - - - - - - - -->

				<div class="comment_body">

					<header class="comment_meta">

						<h6 class="comment_author">
							<?php
							echo sprintf('<a href="%s"><span>%s</span></a>', esc_url(get_comment_author_url()), esc_html(get_comment_author()));
							?>
						</h6>

						<div class="comment-metadata">
							<?php echo sprintf( '<time>%s</time>', comment_date('F j, Y g:i a') ); ?>
						</div>

					</header>

					<?php comment_text(); ?>

					<?php
					echo get_comment_reply_link(array_merge(
						array( 'reply_text' => esc_html__('Reply', 'terminus') ),
						array( 'depth' => $depth, 'max_depth' => $args['max_depth'] )
					));
					?>

				</div><!--/ .comment_body-->

				<!-- - - - - - - - - - - - - - End of Comment Body - - - - - - - - - - - - - - - - -->

			</article>

		</li>

	<?php
	}
}

/* 	Filter Hooks for Respond
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_comments_form_hook')) {

	function terminus_comments_form_hook ($defaults) {

		$commenter = wp_get_current_commenter();

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html_req = ( $req ? " required='required'" : '' );
		$required_text = sprintf( ' ' . esc_html__('Required fields are marked %s', 'terminus'), esc_html__('(required)', 'terminus') );

		$defaults['fields']['author'] = '<div class="row"><div class="col-sm-4"><p class="comment-form-author"><input id="author" placeholder="'. esc_html__( 'Name', 'terminus' ) . ' ' . ( $req ? esc_html__('(required)', 'terminus') : '' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p></div>';

		$defaults['fields']['email'] = '<div class="col-sm-4"><p class="comment-form-email"><input id="email" placeholder="'. esc_html__( 'Email Address', 'terminus' ) . ' ' . ( $req ? esc_html__('(required)', 'terminus') : '' ) . '" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p></div>';

		$defaults['fields']['url'] = '<div class="col-sm-4"><p class="comment-form-url"><input id="url" placeholder="'. esc_html__( 'Website URL', 'terminus' ) . '" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div></div>';

		$defaults['comment_notes_before'] = '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'terminus' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>';

		$defaults['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" placeholder="'. esc_html__( 'Comment', 'terminus' ) . ' ' . ( $req ? esc_html__('(required)', 'terminus') : '' ) . '" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></p>';

		$defaults['cancel_reply_link'] = ' - ' . esc_html__('Cancel quote', 'terminus');

		return $defaults;
	}
	add_filter('comment_form_defaults', 'terminus_comments_form_hook');
}

if ( !function_exists('terminus_comments_form_fields') ) {

	function terminus_comments_form_fields($comment_fields) {
		$a = $comment_fields;
		$a = array_reverse($a);
		$b = array_pop($a);
		$a = array_reverse($a);
		$a['comment'] = $b;

		return $a;
	}

	add_filter('comment_form_fields', 'terminus_comments_form_fields');

}

/*	Array to data string
/* ---------------------------------------------------------------------- */

if ( !function_exists('terminus_create_data_string') ) {
	function terminus_create_data_string($data = array()) {
		$data_string = "";

		if (empty($data)) return;

		foreach ($data as $key => $value) {
			if (is_array($value)) $value = implode(", ", $value);
			$data_string .= " data-$key={$value} ";
		}
		return $data_string;
	}
}

/*	Post ID
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_post_id')) {

	function terminus_post_id() {
		global $post, $terminus_config;
		$post_id = 0;
		if ( isset( $post->ID ) ) {
			$post_id = $post->ID;
			$terminus_config['post_id'] = $post_id;
		} else {
			return get_the_ID();
		}
		return $post_id;
	}
}

/*	Body Background
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_body_background')) {

	function terminus_body_background() {
		$post_id = terminus_post_id();

		$color = rwmb_meta( 'terminus_bg_color', '', $post_id);
		$image = rwmb_meta( 'terminus_bg_image', '', $post_id);

		if (!empty($image) && $image > 0) {
			$image = wp_get_attachment_image_src($image, '');
			if (is_array($image) && isset($image[0])) {
				$image = $image[0];
			}
		}

		$image_repeat     = rwmb_meta( 'terminus_bg_image_repeat', '', $post_id );
		$image_position   = rwmb_meta( 'terminus_bg_image_position', '', $post_id );
		$image_attachment = rwmb_meta( 'terminus_bg_image_attachment', '', $post_id );

		$css = array();

		if (!empty( $image ) && !empty( $image_attachment )) { $css[] = "background-attachment: $image_attachment;"; }
		if (!empty( $image ) && !empty( $image_position ))   { $css[] = "background-position: $image_position;"; }
		if (!empty( $image ) && !empty( $image_repeat ))     { $css[] = "background-repeat: $image_repeat;"; }

		if (!empty( $color ))                     			 { $css[] = "background-color: $color;"; }
		if (!empty( $image ) && $image != 'none') 			 { $css[] = "background-image: url('$image');"; }

		if (empty( $css )) return;
		?>
		<style type="text/css">body { <?php echo implode( ' ', $css ) ?> } </style>

	<?php
	}

	add_filter('wp_head', 'terminus_body_background');
}

/*	Title
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_title')) {

	function terminus_title( $args = false, $id = false ) {

		if ( '' != $id ) $id = terminus_post_id();

		$defaults = array(
			'title' 	  => get_the_title($id),
			'subtitle'    => "",
			'output_html' => "<div class='extra-heading {class}' {attributes}><{heading} class='extra-title'>{title}</{heading}>{additions}</div>",
			'attributes'  => '',
			'class'		  => '',
			'heading'	  => 'h2',
			'additions'	  => ""
		);

		$args = wp_parse_args($args, $defaults);
		extract($args, EXTR_SKIP);

		switch ( terminus_page_title_get_value('mode') ) {
			case 'default':
				$animation = terminus_get_option('page_title_animation');
				break;
			case 'custom':
				$animation = terminus_page_title_get_value('animation');
				break;
			default:
				$animation = '';
				break;
		}

		if ( '' !== $animation ) {
			$class .= 'terminus_animated';
			$attributes .= TERMINUS_HELPER::create_data_string_animation( $animation, 700, '-140' );
		}

		if ( !empty($subtitle) ) {
			$class .= ' with-subtitle';
			$additions .= "<div class='title-meta'>" . do_shortcode(wpautop($subtitle)) . "</div>";
		}

		$output_html = str_replace('{class}', $class, $output_html);
		$output_html = str_replace('{attributes}', $attributes, $output_html);
		$output_html = str_replace('{heading}', $heading, $output_html);
		$output_html = str_replace('{title}', $title, $output_html);
		$output_html = str_replace('{additions}', $additions, $output_html);
		return $output_html;
	}
}

/*	Which Archive
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_which_archive')) {

	function terminus_which_archive() {

		ob_start(); ?>

		<?php if (is_category()): ?>

			<?php echo esc_html__('Archive for Category:', 'terminus') . " " . single_cat_title('', false); ?>

		<?php elseif (is_day()): ?>

			<?php echo esc_html__('Daily Archives:', 'terminus') . " " . get_the_time( __('F jS, Y', 'terminus')); ?>

		<?php elseif (is_month()): ?>

			<?php echo esc_html__('Monthly Archives:', 'terminus') . " " . get_the_time( __('F, Y', 'terminus')); ?>

		<?php elseif (is_year()): ?>

			<?php echo esc_html__('Yearly Archives:', 'terminus') . " " . get_the_time( __('Y', 'terminus')); ?>

		<?php elseif (is_search()): global $wp_query; ?>

			<?php if (!empty($wp_query->found_posts)): ?>

				<?php if ($wp_query->found_posts > 1): ?>

					<?php echo esc_html__('Search results for:', 'terminus')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"; ?>

				<?php else: ?>

					<?php echo esc_html__('Search result for:', 'terminus')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"; ?>

				<?php endif; ?>

			<?php else: ?>

				<?php if (!empty($_GET['s'])): ?>

					<?php echo esc_html__('Search results for:', 'terminus') . " " . esc_attr(get_search_query()); ?>

				<?php else: ?>

					<?php echo esc_html__('To search the site please enter a valid term', 'terminus'); ?>

				<?php endif; ?>

			<?php endif; ?>

		<?php elseif (is_author()): ?>

			<?php $auth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); ?>

			<?php if (isset($auth->nickname) && isset($auth->ID)): ?>

				<?php $name = $auth->nickname; ?>

				<?php echo esc_html__('Author Archive', 'terminus'); ?>
				<?php echo esc_html__('for:', 'terminus') . " " . $name; ?>

			<?php endif; ?>

		<?php elseif (is_tag()): ?>

			<?php echo esc_html__('Posts tagged &ldquo;', 'terminus') . " " . single_tag_title('', false) . '&rdquo;'; ?>

			<?php
			$term_description = term_description();
			if ( ! empty( $term_description ) ) {
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			}
			?>

		<?php elseif (is_tax()): ?>

			<?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>

			<?php if (terminus_is_product_tag()): ?>
				<?php echo esc_html__('Products by:', 'terminus') . ' "' . $term->name . '" tag'; ?>
			<?php elseif(terminus_is_product_category()): ?>
				<?php echo esc_html__('Archive for category:', 'terminus') . " " . single_cat_title('', false); ?>
			<?php else: ?>
				<?php echo esc_html__('Archive for:', 'terminus') . " " . $term->name; ?>
			<?php endif; ?>

		<?php else: ?>

			<?php if (is_post_type_archive()): ?>
				<?php echo sprintf(__('Archive %s', 'terminus'), get_query_var('post_type')); ?>
			<?php else: ?>
				<?php echo esc_html__('Archive', 'terminus'); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}
}

/*	Header Social Links
/* ---------------------------------------------------------------------- */

if (!function_exists('terminus_header_social_links')) {

	function terminus_header_social_links() {
		?>
		<ul class="social_links type_2">

			<?php if ($facebook_link = terminus_get_option('facebook_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($facebook_link) ?>"><i class="icon-facebook"></i></a></li>
			<?php endif; ?>

			<?php if ($twitter_link = terminus_get_option('twitter_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($twitter_link) ?>"><i class="icon-twitter"></i></a></li>
			<?php endif; ?>

			<?php if ($gplus_link = terminus_get_option('gplus_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($gplus_link) ?>"><i class="icon-gplus"></i></a></li>
			<?php endif; ?>

			<?php if ($rss_link = terminus_get_option('rss_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($rss_link) ?>"><i class="icon-rss"></i></a></li>
			<?php endif; ?>

			<?php if ($pinterest_link = terminus_get_option('pinterest_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($pinterest_link) ?>"><i class="icon-pinterest-circled"></i></a></li>
			<?php endif; ?>

			<?php if ($instagram_link = terminus_get_option('instagram_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($instagram_link) ?>"><i class="icon-instagram"></i></a></li>
			<?php endif; ?>

			<?php if ($vimeo_link = terminus_get_option('vimeo_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($vimeo_link) ?>"><i class="icon-vimeo-squared"></i></a></li>
			<?php endif; ?>

			<?php if ($youtube_link = terminus_get_option('youtube_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($youtube_link) ?>"><i class="icon-youtube-play"></i></a></li>
			<?php endif; ?>

			<?php if ($flickr_link = terminus_get_option('flickr_link')): ?>
				<li><a target="_blank" href="<?php echo esc_url($flickr_link) ?>"><i class="icon-flickr"></i></a></li>
			<?php endif; ?>

		</ul>
		<?php
	}

}

if (!function_exists('terminus_breadcrumbs')) {

	function terminus_breadcrumbs( $args = array() ) {
		global $wp_query, $wp_rewrite;

		$trail = array();
		$path = '';
		$breadcrumb = '';

		$defaults = array(
			'after' => false,
			'separator' => '&raquo;',
			'front_page' => true,
			'show_home' => esc_html__( 'Home', 'terminus' ),
			'show_posts_page' => true,
			'truncate' => 80
		);

		if (is_singular()) {
			$defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;
		}
		extract( wp_parse_args( $args, $defaults ) );

		if (!is_front_page() && $show_home) {
			$trail[] = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . $show_home . '</a>';
		}

		if (is_front_page()) {
			if (!$front_page) {
				$trail = false;
			} elseif ($show_home) {
				$trail['end'] = "{$show_home}";
			}
		} elseif (is_home()) {
			$home_page = get_page( $wp_query->get_queried_object_id() );
			$trail = array_merge( $trail, terminus_breadcrumbs_get_parents( $home_page->post_parent, '' ) );
			$trail['end'] = get_the_title( $home_page->ID );
		} elseif (is_singular()) {
			$post = $wp_query->get_queried_object();
			$post_id = absint( $wp_query->get_queried_object_id() );
			$post_type = $post->post_type;
			$parent = $post->post_parent;

			if ('page' !== $post_type && 'post' !== $post_type) {
				$post_type_object = get_post_type_object( $post_type );

				if (!empty( $post_type_object->rewrite['slug'] ) ) {
					$path .= $post_type_object->rewrite['slug'];
				}
				if (!empty($path)) {
					$trail = array_merge( $trail, terminus_breadcrumbs_get_parents( '', $path ) );
				}
				if (!empty( $post_type_object->has_archive) && function_exists( 'get_post_type_archive_link' ) ) {
					$trail[] = '<a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a>';
				}
			}

			if (empty($path) && 0 !== $parent || 'attachment' == $post_type) {
				$trail = array_merge($trail, terminus_breadcrumbs_get_parents($parent, ''));
			}

			if ( 'post' == $post_type && $show_posts_page == true && 'page' == get_option('show_on_front')) {
				$posts_page = get_option('page_for_posts');
				if ($posts_page != '' && is_numeric($posts_page)) {
					$trail = array_merge( $trail, terminus_breadcrumbs_get_parents($posts_page, '' ));
				}
			}

			if ('post' == $post_type) {
				$category = get_the_category();

				foreach ($category as $cat)  {
					if (!empty($cat->parent))  {
						$parents = get_category_parents($cat->cat_ID, TRUE, '$$$', FALSE);
						$parents = explode("$$$", $parents);
						foreach ($parents as $parent_item) {
							if ($parent_item) $trail[] = $parent_item;
						}
						break;
					}
				}

				if (isset($category[0]) && empty($parents)) {
					$trail[] = '<a href="'. esc_url(get_category_link($category[0]->term_id )) .'">'.$category[0]->cat_name.'</a>';
				}

			}

			if (isset( $args["singular_{$post_type}_taxonomy"]) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) ) {
				$trail[] = $terms;
			}

			$post_title = get_the_title($post_id);

			if (!empty($post_title)) {
				$trail['end'] = $post_title;
			}

		} elseif (is_archive()) {

			if (is_tax() || is_category() || is_tag()) {
				$term = $wp_query->get_queried_object();
				$taxonomy = get_taxonomy( $term->taxonomy );

				if ( is_category() ) {
					$path = get_option( 'category_base' );
				} elseif ( is_tag() ) {
					$path = get_option( 'tag_base' );
				} else {
					if ($taxonomy->rewrite['with_front'] && $wp_rewrite->front) {
						$path = trailingslashit($wp_rewrite->front);
					}
					$path .= $taxonomy->rewrite['slug'];
				}

				if ($path) {
					$trail = array_merge($trail, terminus_breadcrumbs_get_parents( '', $path ));
				}

				if (is_taxonomy_hierarchical($term->taxonomy) && $term->parent) {
					$trail = array_merge($trail, terminus_get_term_parents( $term->parent, $term->taxonomy ) );
				}

				$trail['end'] = $term->name;

			} elseif (function_exists( 'is_post_type_archive' ) && is_post_type_archive()) {

				$post_type_object = get_post_type_object(get_query_var('post_type'));

				if (!empty($post_type_object->rewrite['archive'])) {
					$path .= $post_type_object->rewrite['archive'];
				}

				if (!empty($path)) {
					$trail = array_merge( $trail, terminus_breadcrumbs_get_parents( '', $path ));
				}

				$trail['end'] = $post_type_object->labels->name;

			} elseif (is_author()) {
				if (!empty($wp_rewrite->front)) {
					$path .= trailingslashit($wp_rewrite->front);
				}
				if (!empty($wp_rewrite->author_base)) {
					$path .= $wp_rewrite->author_base;
				}
				if (!empty($path)) {
					$trail = array_merge( $trail, terminus_breadcrumbs_get_parents( '', $path ));
				}
				$trail['end'] =  apply_filters('terminus_author_name', get_the_author_meta('display_name', get_query_var('author')), get_query_var('author'));
			} elseif ( is_time()) {
				if (get_query_var( 'minute' ) && get_query_var('hour')) {
					$trail['end'] = get_the_time( esc_html__('g:i a', 'terminus' ));
				} elseif ( get_query_var( 'minute' ) ) {
					$trail['end'] = sprintf( esc_html__('Minute %1$s', 'terminus' ), get_the_time( esc_html__( 'i', 'terminus' ) ) );
				} elseif ( get_query_var( 'hour' ) ) {
					$trail['end'] = get_the_time( esc_html__( 'g a', 'terminus'));
				}
			} elseif (is_date()) {

				if ($wp_rewrite->front) {
					$trail = array_merge($trail, terminus_breadcrumbs_get_parents('', $wp_rewrite->front));
				}

				if (is_day()) {
					$trail[] = '<a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'terminus' ) ) . '">' . get_the_time( esc_html__( 'Y', 'terminus' ) ) . '</a>';
					$trail[] = '<a href="' . esc_url(get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) )) . '" title="' . get_the_time( esc_attr__( 'F', 'terminus' ) ) . '">' . get_the_time( __( 'F', 'terminus' ) ) . '</a>';
					$trail['end'] = get_the_time( esc_html__( 'j', 'terminus' ) );
				} elseif ( get_query_var( 'w' ) ) {
					$trail[] = '<a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'terminus' ) ) . '">' . get_the_time( esc_html__( 'Y', 'terminus' ) ) . '</a>';
					$trail['end'] = sprintf( esc_html__( 'Week %1$s', 'terminus' ), get_the_time( esc_attr__( 'W', 'terminus' ) ) );
				} elseif ( is_month() ) {
					$trail[] = '<a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'terminus' ) ) . '">' . get_the_time( esc_html__( 'Y', 'terminus' ) ) . '</a>';
					$trail['end'] = get_the_time( esc_html__( 'F', 'terminus' ) );
				} elseif ( is_year() ) {
					$trail['end'] = get_the_time( esc_html__( 'Y', 'terminus' ) );
				}
			}
		} elseif ( is_search() ) {
			$trail['end'] = sprintf( esc_html__( 'Search results for &quot;%1$s&quot;', 'terminus' ), esc_attr( get_search_query() ) );
		} elseif ( is_404() ) {
			$trail['end'] = esc_html__( '404 Not Found', 'terminus' );
		}

		if (is_array($trail)) {
			if (!empty($trail['end'])) {
				if (!is_search()) {
					$trail['end'] = $trail['end'];
				}
				$trail['end'] = '<span class="trail-end">' . $trail['end'] . '</span>';
			}
			if (!empty($separator)) {
				$separator = '<span class="separate">'. $separator .'</span>';
			}
			$breadcrumb = join(" {$separator} ", $trail);

			if (!empty($after)) {
				$breadcrumb .= ' <span class="breadcrumb-after">' . $after . '</span>';
			}
		}
		return $breadcrumb;
	}
}

if (!function_exists('terminus_breadcrumbs_get_parents')) {

	function terminus_breadcrumbs_get_parents($post_id = '', $path = '') {
		$trail = array();

		if (empty($post_id) && empty($path)) {
			return $trail;
		}

		if (empty($post_id)) {
			$parent_page = get_page_by_path($path);

			if (empty($parent_page)) {
				$parent_page = get_page_by_title($path);
			}
			if (empty($parent_page)) {
				$parent_page = get_page_by_title (str_replace( array('-', '_'), ' ', $path));
			}
			if (!empty($parent_page)) {
				$post_id = $parent_page->ID;
			}
		}

		if ($post_id == 0 && !empty($path )) {
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );

			if ( isset( $matches ) ) {
				$matches = array_reverse( $matches );
				foreach ( $matches as $match ) {

					if ( isset( $match[0] ) ) {
						$path = str_replace( $match[0], '', $path );
						$parent_page = get_page_by_path( trim( $path, '/' ) );

						if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
							$post_id = $parent_page->ID;
							break;
						}
					}
				}
			}
		}

		while ( $post_id ) {
			$page = get_page($post_id);
			$parents[]  = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
			if(is_object($page)) {
				$post_id = $page->post_parent;
			} else {
				$post_id = "";
			}
		}
		if (isset($parents)) {
			$trail = array_reverse($parents);
		}
		return $trail;
	}

}

if (!function_exists('terminus_get_term_parents')) {

	function terminus_get_term_parents($parent_id = '', $taxonomy = '') {
		$trail = array();
		$parents = array();

		if (empty( $parent_id ) || empty($taxonomy)) {
			return $trail;
		}
		while ($parent_id) {
			$parent = get_term( $parent_id, $taxonomy );
			$parents[] = '<a href="' . esc_url(get_term_link( $parent, $taxonomy )) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a>';
			$parent_id = $parent->parent;
		}
		if (!empty($parents)) {
			$trail = array_reverse($parents);
		}
		return $trail;
	}

}

if ( !function_exists('terminus_woocommerce_set_defaults') ) {

	function terminus_woocommerce_set_defaults() {

		$disabled_options = array('woocommerce_enable_lightbox', 'woocommerce_frontend_css');

		foreach ( $disabled_options as $option ) {
			update_option( $option, false );
		}

	}

	add_action('terminus_backend_theme_activation', 'terminus_woocommerce_set_defaults');

}


if (!function_exists('terminus_maps_key_for_plugins')) {

	add_filter( 'script_loader_src', 'terminus_maps_key_for_plugins', 10 , 99, 2 );

	function terminus_maps_key_for_plugins ( $url, $handle  ) {

		$key = terminus_get_option( 'gmap_api' );

		if ( ! $key ) { return $url; }

		if ( strpos( $url, "maps.google.com/maps/api/js" ) !== false || strpos( $url, "maps.googleapis.com/maps/api/js" ) !== false ) {
			if ( strpos( $url, "key=" ) === false ) {
				$url = "http://maps.google.com/maps/api/js?v=3.24";
				$url = esc_url( add_query_arg( 'key', $key, $url) );
			}
		}

		return $url;
	}
}