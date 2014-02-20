<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Quizumba
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php quizumba_the_post_thumbnail( 'singular' ); ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</a>

					<div class="entry-meta">
						<?php quizumba_posted_on(); ?>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'quizumba' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->

				<footer class="entry-meta">
					<?php quizumba_the_category_list(); ?>
					<?php quizumba_the_tag_list(); ?>
					<?php edit_post_link( __( 'Edit', 'quizumba' ), '<span class="edit-link icon-edit">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-## -->

			<?php quizumba_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>