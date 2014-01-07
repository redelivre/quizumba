<?php
/**
 * The template for displaying posts in the Gallery post format
 * 
 * @package Quizumba
 * @since  Quizumba 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
		if ( function_exists( 'get_post_gallery' ) ) {
			echo get_post_gallery();
		} else {
			echo quizumba_get_post_gallery();
		}
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php quizumba_the_post_format(); ?>
		<?php quizumba_posted_on(); ?>
		<?php edit_post_link( __( 'Edit', 'quizumba' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
