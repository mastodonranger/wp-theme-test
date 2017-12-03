<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" <?php language_attributes(); ?>>  <!--<![endif]-->
<head>

	<!-- Basic Page Needs
    ==================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- Favicons
	==================================================== -->
	<?php if (function_exists('wp_site_icon') && has_site_icon()): ?>
		<?php wp_site_icon(); ?>
	<?php else: ?>
		<?php terminus_wp_site_icon(); ?>
	<?php endif; ?>

	<!-- Mobile Specific Metas
	==================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<?php wp_head(); ?>

</head>

<?php
global $terminus_config;
$header_classes = $terminus_config['header_classes'];
$header_style = $terminus_config['header_style'];
$sidebar_position = $terminus_config['sidebar_position'];
?>

<body <?php body_class(); ?>>

<?php do_action('terminus_body_append'); ?>

<!-- - - - - - - - - - - - - - Theme Wrapper - - - - - - - - - - - - - - - - -->

<div id="theme-wrapper">

	<!-- - - - - - - - - - - - - Mobile Menu - - - - - - - - - - - - - - -->

	<nav id="mobile-advanced" class="mobile-advanced"></nav>

	<!-- - - - - - - - - - - - / Mobile Menu - - - - - - - - - - - - - -->

	<!-- - - - - - - - - - - - - - Layout - - - - - - - - - - - - - - - - -->

	<div class="wide_layout">

		<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->

		<header id="header" class="<?php echo esc_attr($header_classes); ?>">
			<?php do_action( 'terminus_header_layout', $header_style ); ?>
		</header><!--/ #header -->

		<!-- - - - - - - - - - - - - - / Header - - - - - - - - - - - - - - -->

		<?php
			/**
			 * terminus_header_after hook
			 *
			 * @hooked aside_panel
			 * @hooked page_title_and_breadcrumbs
			 */

			do_action('terminus_header_after');
		?>

		<!-- - - - - - - - - - - - - Page Content - - - - - - - - - - - - - -->

		<div class="page_wrap <?php echo esc_attr($sidebar_position); ?>">

			<?php if ( $sidebar_position != 'no_sidebar' ): ?>

				<div class="container">

					<?php
						/**
						 * terminus_before_content hook
						 *
						 * @hooked terminus_before_content - 10
						 */
						do_action('terminus_before_content');
					?>

					<div class="row">

						<main id="main" class="col-sm-8">

			<?php else: ?>

				<div class="container">

					<?php
					/**
					 * terminus_before_content hook
					 *
					 * @hooked terminus_before_content - 10
					 */
					do_action('terminus_before_content');
					?>

					<div class="row">

						<div class="col-sm-12">

			<?php endif; ?>