<?php
/**
 * @package Quizumba
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php quizumba_the_post_format(); ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php quizumba_the_post_thumbnail( 'archive' ); ?>
		</a>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<?php quizumba_posted_on(); ?>

		<?php quizumba_the_category_list(); ?>

		<?php quizumba_the_tag_list(); ?>

		<?php edit_post_link( __( 'Edit', 'quizumba' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
