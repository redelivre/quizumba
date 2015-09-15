<?php
/**
 * Quizumba functions and definitions
 *
 * @package Quizumba
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 642; /* pixels */
}

if ( ! function_exists( 'quizumba_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function quizumba_setup() {
	// Customizer
	require( get_template_directory() . '/inc/hacklab_post2home/hacklab_post2home.php' );
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Quizumba, use a find and replace
	 * to change 'quizumba' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'quizumba', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'archive', 362, 9999 );
	add_image_size( 'singular', 642, 380, false );
	add_image_size( 'slider', 517, 300, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'quizumba' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

}
endif; // quizumba_setup
add_action( 'after_setup_theme', 'quizumba_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function quizumba_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'quizumba' ),
		'id'            => 'sidebar-main',
		'description'	=> __( 'The main sidebar', 'quizumba' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
			'name'          => __( 'Home page widgets area', 'quizumba' ),
			'id'            => 'sidebar-home',
			'description'	=> __( 'The home page widgets area below highlights, if highlights is enabled', 'quizumba' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'quizumba' ),
		'id'            => 'sidebar-footer',
		'description'	=> __( 'The widget area on the footer', 'quizumba' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
			'name'          => __( 'Footer Supporters Widget Area', 'quizumba' ),
			'id'            => 'sidebar-footer-2',
			'description'	=> __( 'The widget area for supporters info on the footer', 'quizumba' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'quizumba_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function quizumba_scripts() {

	// slideshow.css
	wp_register_style( 'quizumba-slideshow', get_template_directory_uri() . '/css/slideshow.css', array(), '1' );
	wp_enqueue_style( 'quizumba-slideshow' );
	
	// Normalize.css
    wp_register_style( 'quizumba-normalize', get_template_directory_uri() . '/css/normalize.css', array(), '2.1.3' );
    wp_enqueue_style( 'quizumba-normalize' );

    // Google Fonts
    wp_register_style( 'quizumba-fonts', 'http://fonts.googleapis.com/css?family=Raleway:500,700' );
    wp_enqueue_style( 'quizumba-fonts' );

    // Main style
	wp_enqueue_style( 'quizumba-style', get_stylesheet_uri() );

	// Navigation
	wp_enqueue_script( 'quizumba-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	// Masonry
	if ( quizumba_page_uses_masonry() ) {
		wp_enqueue_script('quizumba-images-loaded', get_template_directory_uri().'/js/imagesloaded.pkgd.min.js', false, '3.1.1', true );
		wp_enqueue_script( 'quizumba-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'quizumba-images-loaded' ), '3.1.3', true );
	}

	// FitVids
	wp_enqueue_script('quizumba-fitvids', get_template_directory_uri().'/js/jquery.fitvids.js', array( 'jquery' ), '1.0.3', true );

   	// Loads JavaScript file with functionality specific to Quizumba
    wp_enqueue_script( 'quizumba-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '', true );

	// Skip link
	wp_enqueue_script( 'quizumba-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	

}
add_action( 'wp_enqueue_scripts', 'quizumba_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add Facebook scripts for the theme
 *
 * @todo Create an option page (or maybe in Customizer) to insert App ID
 */
function quizumba_fb_comments_box() {

	$fb_appid = get_theme_mod( 'quizumba_facebook_appid' );
	?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=<?php echo $fb_appid; ?>&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<script>
		var siteLeadUrl = "<?php echo get_template_directory_uri() . "/js/site-lead.js" ?>";
		Modernizr.load({
	        test: Modernizr.mq("only screen and (min-width:64.063em)"),
	        yep: siteLeadUrl
		});
	</script>

	<?php
}
add_action( 'wp_footer', 'quizumba_fb_comments_box' );

/**
 * Add Facebook OpenGraph meta properties
 */
function quizumba_fb_opengraph() {
	$fb_appid = get_theme_mod( 'quizumba_facebook_appid' );

	if ( ! empty ( $fb_appid ) ) {
		echo '<meta property="fb:app_id" content="' . $fb_appid . '"/>';
	}	
}
add_action( 'wp_head', 'quizumba_fb_opengraph' );

