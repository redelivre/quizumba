<?php
/**
 * Default content template
 * 
 * @package Quizumba
 * @since  Quizumba 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php quizumba_the_post_thumbnail( 'archive' ); ?>
		</a>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<?php quizumba_the_post_format(); ?>
		<?php quizumba_posted_on(); ?>
		<?php edit_post_link( __( 'Edit', 'quizumba' ), '<span class="edit-link icon-edit">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
