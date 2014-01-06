<?php
/**
 * The template for displaying posts in the Quote post format
 * 
 * @package Quizumba
 * @since  Quizumba 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php quizumba_the_post_format(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php quizumba_posted_on(); ?>

		<?php quizumba_the_category_list(); ?>

		<?php quizumba_the_tag_list(); ?>

		<?php edit_post_link( __( 'Edit', 'quizumba' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
