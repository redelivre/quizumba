<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Quizumba
 */
?>

		</div><!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container container--padding">
			<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		        <div id="tertiary" class="widget-area widget-area--footer clear" role="complementary">
		                <?php dynamic_sidebar( 'sidebar-footer' ); ?>
		        </div><!-- .widget-area--footer -->
	        <?php endif; ?>
	        <?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
		        <div id="quaternary" class="widget-area widget-area--footer widget-area--supporters clear" role="complementary">
		                <?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
		        </div><!-- .widget-area--footer-2 -->
	        <?php endif; ?>
			<div class="site-info">
				<?php do_action( 'quizumba_credits' ); ?>
				<a href="http://wordpress.org/" rel="generator"><?php printf( __( 'Proudly powered by %s', 'quizumba' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'quizumba' ), 'Quizumba', '<a href="http://quizumba.redelivre.org.br" rel="designer">Rede Livre</a>' ); ?>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>