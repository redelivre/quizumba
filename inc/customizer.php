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

    /**
     * Customize Image Reloaded Class
     *
     * Extend WP_Customize_Image_Control allowing access to uploads made within
     * the same context
     * 
     */
    class My_Customize_Image_Reloaded_Control extends WP_Customize_Image_Control {
        /**
         * Constructor.
         *
         * @since 3.4.0
         * @uses WP_Customize_Image_Control::__construct()
         *
         * @param WP_Customize_Manager $manager
         */
        public function __construct( $manager, $id, $args = array() ) {
                parent::__construct( $manager, $id, $args );
        }
        
        /**
        * Search for images within the defined context
        * If there's no context, it'll bring all images from the library
        * 
        */
        public function tab_uploaded() {
            $my_context_uploads = get_posts( array(
                'post_type'  => 'attachment',
                'meta_key'   => '_wp_attachment_context',
                'meta_value' => $this->context,
                'orderby'    => 'post_date',
                'nopaging'   => true,
            ) );
            
            ?>
            
            <div class="uploaded-target"></div>
            
            <?php
            if ( empty( $my_context_uploads ) )
                return;
            
            foreach ( (array) $my_context_uploads as $my_context_upload ) {
                $this->print_tab_image( esc_url_raw( $my_context_upload->guid ) );
            }
        }
    }

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // Branding section
    $wp_customize->add_section( 'quizumba_branding', array(
            'title'    => __( 'Branding', 'quizumba' ),
            'priority' => 30,
    ) );
    
    // Branding section: logo uploader
    $wp_customize->add_setting( 'quizumba_logo', array(
            'capability'  => 'edit_theme_options'
    ) );
        
    $wp_customize->add_control( new My_Customize_Image_Reloaded_Control( $wp_customize, 'quizumba_logo', array(
        'label'     => __( 'Logo', 'quizumba' ),
        'section'   => 'quizumba_branding',
        'settings'  => 'quizumba_logo',
        'context'   => 'quizumba-custom-logo'
    ) ) );


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
            a:visited,
            a:hover,
            a:active,
            a:focus {
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

/**
 * Get 'quizumba_logo' ID and use it to define the default logo size
 * 
 * @param  string $value The attachment guid, which is the full imagem URL
 * @return string $value The new image size for 'quizumba_logo'
 */
function quizumba_get_customizer_logo_size( $value ) {
    global $wpdb;

    if ( ! is_numeric( $value ) ) {
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid = %s ORDER BY post_date DESC LIMIT 1;", $value ) );
        if ( ! is_wp_error( $attachment_id ) && wp_attachment_is_image( $attachment_id ) )
            $value = $attachment_id;
    }

    $image_attributes = wp_get_attachment_image_src( $value, 'archive' );

    $value = $image_attributes[0];

    return $value;
}
add_filter( 'theme_mod_quizumba_logo', 'quizumba_get_customizer_logo_size' );
