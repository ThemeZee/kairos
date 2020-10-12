<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @version 1.0
 * @package Kairos
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="main" class="site-main" role="main">

		<?php
			get_template_part( 'template-parts/page/content', 'page' );
		?>

	</main><!-- #main -->

	<?php
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile;

get_footer();
