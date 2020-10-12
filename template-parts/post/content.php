<?php
/**
 * The template for displaying single posts
 *
 * @version 1.0
 * @package Kairos
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="post-header entry-header">

		<?php kairos_entry_categories(); ?>

		<?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>

		<?php kairos_entry_meta(); ?>

	</header><!-- .entry-header -->

	<?php get_template_part( 'template-parts/entry/entry', 'single' ); ?>

</article>
