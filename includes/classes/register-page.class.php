<?php
if (!class_exists('TERMINUS_PAGE')) {

	class TERMINUS_PAGE {

		public function __construct() {
			add_action('init', array(&$this, 'init'));
		}

		public function init() {
			add_filter("manage_posts_columns", array(&$this, "manage_posts_columns"));
			add_action("manage_posts_custom_column", array(&$this, "manage_posts_custom_column"));
		}

		public function manage_posts_columns($columns) {
			$new_columns = array(
				"cb" => "<input type=\"checkbox\" />",
				"thumb column-comments" => esc_html__('Thumb', 'terminus'),
				"title" => esc_html__("Title", 'terminus')
			);

			$columns = array_merge($new_columns, $columns);
			return $columns;
		}

		public function manage_posts_custom_column($column) {
			global $post;

			switch ($column) {
				case "thumb column-comments":
					if (has_post_thumbnail($post->ID)){
						echo TERMINUS_HELPER::get_the_post_thumbnail($post->ID, '40*40', true);
					}
					break;
			}
		}

	}
}

