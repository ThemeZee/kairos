<?php
/**
 * The template for displaying articles in the two column grid layout
 *
 * @version 1.0
 * @package Occasio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php occasio_post_image_archives(); ?>

	<header class="post-header entry-header">

		<?php occasio_entry_categories(); ?>

		<?php the_title( sprintf( '<h2 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php occasio_entry_meta(); ?>

	</header><!-- .entry-header -->

	<?php get_template_part( 'template-parts/entry/entry', esc_html( occasio_get_option( 'blog_content' ) ) ); ?>

</article>
