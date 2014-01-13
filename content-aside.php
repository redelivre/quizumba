<?php
/**
 * The template for displaying posts in the Aside post format
 * 
 * @package Quizumba
 * @since  Quizumba 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php quizumba_the_post_format(); ?>
		<?php quizumba_posted_on(); ?>
		<?php edit_post_link( __( 'Edit', 'quizumba' ), '<span class="edit-link icon-edit">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	
</article><!-- #post-## -->
