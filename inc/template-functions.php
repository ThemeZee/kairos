<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Occasio
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function occasio_body_classes( $classes ) {

	// Get theme options from database.
	$theme_options = occasio_theme_options();

	// Set Theme Layout.
	if ( 'wide' === $theme_options['theme_layout'] ) {
		$classes[] = 'wide-theme-layout';
	} elseif ( 'centered' === $theme_options['theme_layout'] ) {
		$classes[] = 'centered-theme-layout';
	}

	// Add Sidebar class.
	if ( occasio_has_sidebar() ) {
		$classes[] = 'has-sidebar';
	}

	// Check if sidebar is displayed on the left.
	if ( occasio_has_sidebar() && 'left-sidebar' === $theme_options['sidebar_position'] &&
		! is_page_template( 'templates/template-sidebar-right.php' ) && ! is_page_template( 'templates/template-sidebar-right-no-title.php' ) ) {
		$classes[] = 'sidebar-left';
	}

	// Hide Site Title?
	if ( false === $theme_options['site_title'] ) {
		$classes[] = 'site-title-hidden';
	}

	// Hide Site Description?
	if ( false === $theme_options['site_description'] ) {
		$classes[] = 'site-description-hidden';
	}

	// Set Blog Layout.
	if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type() ) {
		if ( 'horizontal-list' === $theme_options['blog_layout'] ) {
			$classes[] = 'blog-layout-horizontal-list';
		} elseif ( 'vertical-list' === $theme_options['blog_layout'] ) {
			$classes[] = 'blog-layout-vertical-list';
		} elseif ( 'two-column-grid' === $theme_options['blog_layout'] ) {
			$classes[] = 'blog-layout-two-column-grid';
		} elseif ( 'three-column-grid' === $theme_options['blog_layout'] ) {
			$classes[] = 'blog-layout-three-column-grid';
		}
	}

	// Hide Date?
	if ( ( false === $theme_options['meta_date'] && ! is_single() )
		or ( false === $theme_options['single_meta_date'] && is_single() ) ) {
		$classes[] = 'date-hidden';
	}

	// Hide Author?
	if ( ( false === $theme_options['meta_author'] && ! is_single() )
		or ( false === $theme_options['single_meta_author'] && is_single() ) ) {
		$classes[] = 'author-hidden';
	}

	// Hide Categories?
	if ( ( false === $theme_options['meta_categories'] && ! is_single() )
		or ( false === $theme_options['single_meta_categories'] && is_single() ) ) {
		$classes[] = 'categories-hidden';
	}

	// Hide Comments?
	if ( ( false === $theme_options['meta_comments'] && ! is_single() )
		or ( false === $theme_options['single_meta_comments'] && is_single() ) ) {
		$classes[] = 'comments-hidden';
	}

	// Hide Tags?
	if ( false === $theme_options['meta_tags'] ) {
		$classes[] = 'tags-hidden';
	}

	// Hide Post Navigation in Customizer for instant live preview.
	if ( is_customize_preview() && is_single() && false === $theme_options['post_navigation'] ) {
		$classes[] = 'post-navigation-hidden';
	}

	// Hide Credit Link in Customizer for instant live preview.
	if ( is_customize_preview() && false === $theme_options['credit_link'] ) {
		$classes[] = 'credit-link-hidden';
	}

	// Check for AMP pages.
	if ( occasio_is_amp() ) {
		$classes[] = 'is-amp-page';
	}

	// Add Blog Page class?
	if ( occasio_is_blog_page() ) {
		$classes[] = 'is-blog-page';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'occasio_body_classes' );


/**
 * Check if we are on a blog page or single post.
 *
 * @return bool
 */
function occasio_is_blog_page() {
	return ( 'post' === get_post_type() ) && ( is_home() || is_archive() || is_single() );
}


/**
 * Check if sidebar should be displayed.
 *
 * @return bool
 */
function occasio_has_sidebar() {
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return false;
	}

	if ( occasio_is_blog_page() && ! is_page_template( 'templates/template-no-sidebar.php' ) ) {
		return true;
	}

	if ( is_page_template( 'templates/template-sidebar-left.php' ) or is_page_template( 'templates/template-sidebar-left-no-title.php' ) or
		is_page_template( 'templates/template-sidebar-right.php' ) or is_page_template( 'templates/template-sidebar-right-no-title.php' ) ) {
		return true;
	}

	return false;
}


/**
 * Add custom CSS to scale down logo image for retina displays.
 *
 * @return void
 */
function occasio_retina_logo() {
	// Return early if there is no logo image or option for retina logo is disabled.
	if ( ! has_custom_logo() or false === occasio_get_option( 'retina_logo' ) ) {
		return;
	}

	// Get Logo Image.
	$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

	// Create CSS.
	$css = '.site-logo .custom-logo { width: ' . absint( floor( $logo[1] / 2 ) ) . 'px; }';

	// Add Custom CSS.
	wp_add_inline_style( 'occasio-stylesheet', $css );
}
add_filter( 'wp_enqueue_scripts', 'occasio_retina_logo', 11 );


/**
 * Change excerpt length for default posts
 *
 * @param int $length Length of excerpt in number of words.
 * @return int
 */
function occasio_excerpt_length( $length ) {

	if ( is_admin() ) {
		return $length;
	}

	// Get excerpt length from database.
	$excerpt_length = occasio_get_option( 'excerpt_length' );

	// Return excerpt text.
	if ( $excerpt_length >= 0 ) :
		return absint( $excerpt_length );
	else :
		return 55; // Number of words.
	endif;
}
add_filter( 'excerpt_length', 'occasio_excerpt_length' );


/**
 * Change excerpt more text for posts
 *
 * @param String $more_text Excerpt More Text.
 * @return string
 */
function occasio_excerpt_more( $more_text ) {

	if ( is_admin() ) {
		return $more_text;
	}

	return esc_html( ' ' . occasio_get_option( 'excerpt_more_text' ) );
}
add_filter( 'excerpt_more', 'occasio_excerpt_more' );
