<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @version 1.0
 * @package Kairos
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

	<?php do_action( 'kairos_before_site' ); ?>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kairos' ); ?></a>

		<?php do_action( 'kairos_before_header' ); ?>

		<header id="masthead" class="site-header" role="banner">

			<div class="header-main">

				<?php kairos_site_logo(); ?>

				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

				<?php get_template_part( 'template-parts/header/site', 'navigation' ); ?>

			</div><!-- .header-main -->

		</header><!-- #masthead -->

		<?php do_action( 'kairos_after_header' ); ?>

		<?php kairos_header_image(); ?>

		<div id="content" class="site-content">

			<?php kairos_breadcrumbs(); ?>
