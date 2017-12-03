<form class="searchform_inline" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" autocomplete="off" name="s" id="s"
		   placeholder="<?php esc_attr_e( 'Search', 'terminus' ) ?>"
		   value="<?php echo get_search_query(); ?>">
	<button type="submit" class="submit-search" id="searchsubmit">
		<span class="si-icon si-icon-search"></span>
	</button>
</form>