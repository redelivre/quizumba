<?php
/**
 * Quizumba Theme Customizer
 *
 * @package Quizumba
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function quizumba_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	// Color section: link color
    $wp_customize->add_setting( 'quizumba_link_color', array(
        'default'	=> '#d4802c',
        'transport'	=> 'postMessage'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'quizumba_link_color', array(
        'label'      => __( 'Link & Details Color', 'quizumba' ),
        'section'    => 'colors',
        'setting'   => 'quizumba_link_color'
    ) ) );

}
add_action( 'customize_register', 'quizumba_customize_register' );

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 * 
 * Used for inline custom CSS
 *
 * @since quizumba 1.0
 */
function quizumba_customize_css() {
    ?>
    <!-- Customizer options -->
    <style type="text/css">
	    <?php
	    $color_scheme = get_theme_mod( 'quizumba_color_scheme' );
	    if ( isset( $color_scheme ) && $color_scheme == 'dark' ) : ?>
	            .site-header,
	            .site-footer {
	                    background-color: #000;
	                    color: #fff;
	            }

	            .main-navigation ul ul {
	                    background: #000;
	            }

	            .widget-area--footer + .site-info {
	                    border-color: #222;
	            }
	    <?php endif; ?>


	    <?php
	    $link_color = get_theme_mod( 'quizumba_link_color' );
        if ( ! empty( $link_color ) && $link_color != '#d4802c' ) : ?>
            a,
            a:visited {
                color: <?php echo $link_color; ?>;
            }
            .site-header,
            .site-footer {
            	border-color: <?php echo $link_color; ?>;
            }
   		<?php endif; ?>
    </style> 
    <!-- /Customizer options -->
    <?php
}
add_action( 'wp_head', 'quizumba_customize_css' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function quizumba_customize_preview_js() {
	wp_enqueue_script( 'quizumba_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'quizumba_customize_preview_js' );

/**
 * Add Customizer inside Appearance submenu if it's not present already
 *
 * @since  Quizumba 1.0
 */
function quizumba_admin_customizer_menu_link() {

    global $menu, $submenu;

    $customizer_menu = false;
    $customizer_link = 'customize.php';
    
    // Check if there's already a submenu for customize.php
    foreach( $submenu as $k => $item ) {
	    foreach( $item as $sub ) {
	    	if( $customizer_link == $sub[2] ) {
	        	$customizer_menu = true;
	      	}
	    }
    }

    if ( ! $customizer_menu && current_user_can( 'edit_theme_options' ) ) {
	    add_theme_page( __( 'Customize', 'default' ), __( 'Customize', 'default' ), 'edit_theme_options', $customizer_link );
	}

}
add_action ( 'admin_menu', 'quizumba_admin_customizer_menu_link', 99 );
