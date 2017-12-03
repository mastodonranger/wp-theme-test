
<?php
$id = get_the_author_meta('ID');
$name  = get_the_author_meta('display_name', $id);
$email = get_the_author_meta('email', $id);
$heading = esc_html__("Posted by", 'terminus') ." ". $name;
$description = get_the_author_meta('description', $id);

if (empty($description)) return;

if ( current_user_can('edit_users') || get_current_user_id() == $id ) {
	$description .= " <a href='" . admin_url( 'profile.php?user_id=' . $id ) . "'>". esc_html__( '[ Edit the profile ]', 'terminus' ) ."</a>";
}

?>

<div class="entry_author">

	<div class="author_photo">
		<?php echo get_avatar($email, '100', '', esc_html($name)); ?>
	</div><!--/ .author_photo -->

	<div class="about_author">

		<h4><?php echo esc_html($heading); ?></h4>

		<div class="author-desc"><?php echo sprintf('%s', $description); ?></div>

		<?php
			$user_profile = new terminus_admin_user_profile();
			echo $user_profile->output_social_links();
		?>

	</div><!--/ .about_author -->

</div>