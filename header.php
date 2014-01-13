<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Quizumba
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-complementary">
			<div class="container">
                <?php
                // Social networks & RSS feed
				$social = get_option( 'campanha_social_networks' );
				if ( isset( $social ) && !empty( $social ) ) : ?>
					<div class="social">
						<?php
						foreach ( $social as $key => $value ) :
							if ( ! empty( $value) ) : ?>
								<a class="social-link social-link-<?php echo $key; ?>" href="<?php echo esc_url( $value ); ?>"><span class="icon icon-<?php echo $key; ?>"></span></a>
							<?php
							endif;
						endforeach;
						?>
						<a class="social-link social-link-rss" href="<?php bloginfo( 'rss2_url' ); ?>"><span class="icon icon-rss"></span></a>
					</div><!-- .social -->
				<?php endif; ?>
			</div>
		</div><!-- .site-complementary -->

		<div class="site-branding">
			<div class="container container--padding">
				<?php
			    // Check if there's a custom logo
			    $logo = get_theme_mod( 'quizumba_logo' );
			    if ( isset( $logo ) && ! empty( $logo ) ) : ?>
		            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		                <img class="site-logo" src="<?php echo $logo; ?>" alt="Logo <?php bloginfo ( 'name' ); ?>" />
		            </a>
			    <?php endif; ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- .container -->
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<h1 class="menu-toggle"><span class="icon-menu"><?php _e( 'Menu', 'quizumba' ); ?></span></h1>
				<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'quizumba' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</div><!-- .container -->
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="container container--padding">
