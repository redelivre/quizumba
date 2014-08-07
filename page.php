<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
					<?php edit_post_link( __( 'Edit', 'quizumba' ), '<footer class="entry-meta"><span class="edit-link icon-edit">', '</span></footer>' ); ?>
				</article><!-- #post-## -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
			if( get_theme_mod('quizumba_display_fb_comments') == 1 )
				{ ?> 
				<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light" data-width="100%"></div>
			<?php }	
			endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
