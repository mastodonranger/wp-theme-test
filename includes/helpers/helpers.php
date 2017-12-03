<?php

/* Get Search Btn */
if ( ! function_exists( 'terminus_base_search_btn' ) ) {
	function terminus_base_search_btn() {
		return terminus_base_functions()->search_btn();
	}
}

/* Get Share Btn */
if ( ! function_exists( 'terminus_base_post_share_btn' ) ) {
	function terminus_base_post_share_btn($post_id) {
		return terminus_base_functions()->post_share_btn($post_id);
	}
}