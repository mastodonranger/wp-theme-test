<?php

if ( !class_exists('TERMINUS_VC_TABLE') ) {

	class TERMINUS_VC_TABLE extends TERMINUS_PLUGINS_CONFIG {

		function __construct() {

			if ( !defined( 'WPB_VC_TABLE_MANAGER_VERSION' ) ) return;

			$this->add_hooks();
		}

		public function add_hooks() {
			add_action('wp_enqueue_scripts', array(&$this, 'enqueue_styles_scripts'));
		}

		public function enqueue_styles_scripts() { }

	}

}