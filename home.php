<?php
/**
 * Home template file.
 *
 * @package Quizumba
 */

get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		
		<?php
		if( get_theme_mod('quizumba_display_slider') == 1 )
		{  
			$feature = new WP_Query( array( 'posts_per_page' => -1, 'ignore_sticky_posts' => 1, 'meta_key' => '_home', 'meta_value' => 1 ) );
			if ( $feature->have_posts() ) : ?>

			<div class="cycle-slideshow highlights" >
						<ul class="slides">
			        	<div class="cycle-pager"></div>
			        	<div class="cycle-prev"></div>
   					 	<div class="cycle-next"></div>
				        <?php while ( $feature->have_posts() ) : $feature->the_post(); ?>
					        <li class="cycles-slide">
						        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						        	<div class="media slide cf">
						    			<?php if ( has_post_thumbnail() ) : ?>
							    			<div class="entry-image">
							    			<?php the_post_thumbnail( 'slider' ); ?>
							    			</div>
						    			<?php endif; ?>
						        		<div class="bd">
						        			<div class="entry-meta">
							        			<?php $category = get_the_category(); ?>
												<a href="<?php echo get_category_link( $category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a>
											</div>
						        			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo substr(the_title($before = '', $after = '', FALSE), 0, 60).'...'; ?></a></h2>
						        			<div class="entry-summary">
							        			<?php the_excerpt(); ?>
						        			</div>
						        		</div>
						        	</div><!-- /slide -->
						        </article><!-- /article -->
					        </li>
			        	<?php endwhile; ?>
						
			        	</ul><!-- .swiper-wrapper -->
			</div><!-- .swiper-container -->
			<?php
			wp_reset_postdata();
			
			else : ?>
				<?php if ( current_user_can( 'edit_theme_options' ) ): ?>
					<div class="empty-feature">
		                <p><?php printf( __( 'To display your featured posts here go to the <a href="%s">Post Edit Page</a> and check the "Feature" box. You can select how many posts you want, but use it wisely.', 'guarani' ), admin_url('edit.php') ); ?></p>
					</div>
				<?php
				endif;
			endif; // have_posts()
		}
		?>
	 		<div class="clearfix"> </div>

	 		<?php 
	 		if ( have_posts() ) : ?>
				<div class="loop js-masonry">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div><!-- .loop.js-masonry -->
	
				<?php quizumba_paging_nav(); ?>
			<?php 
			else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php 
			endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
