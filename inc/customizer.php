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

    // Remove default controls
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->remove_control( 'header_textcolor' );

    // Set postMessage transport
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // Site title & tagline
    $wp_customize->add_setting( 'quizumba_display_header_text', array(
        'capability'        => 'edit_theme_options',
        'default'           => true,
        'transport'         => 'postMessage'
    ) );

    $wp_customize->add_control( 'quizumba_display_header_text', array(
        'label'     => __( 'Display Header Text' ),
        'section'   => 'title_tagline',
        'type'      => 'checkbox',
        'setting'   => 'quizumba_display_header_text'
    ) );

    // Branding section
    $wp_customize->add_section( 'quizumba_branding', array(
        'title'    => __( 'Branding', 'quizumba' ),
        'priority' => 30,
    ) );
    
    // Branding section: logo uploader
    $wp_customize->add_setting( 'quizumba_logo', array(
        'capability'  => 'edit_theme_options',
        'sanitize_callback' => 'quizumba_get_customizer_logo_size',
    	//'transport'         => 'postMessage'
    ) );
        
    $wp_customize->add_control( new My_Customize_Image_Reloaded_Control( $wp_customize, 'quizumba_logo', array(
        'label'     => __( 'Logo', 'quizumba' ),
        'section'   => 'quizumba_branding',
        'settings'  => 'quizumba_logo',
        'context'   => 'quizumba-custom-logo'
    ) ) );

	// Color section: link color
    $wp_customize->add_setting( 'quizumba_link_color', array(
        'default'	=> '#d6812c',
        'transport'	=> 'postMessage'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'quizumba_link_color', array(
        'label'      => __( 'Link & Details Color', 'quizumba' ),
        'section'    => 'colors',
        'setting'   => 'quizumba_link_color'
    ) ) );

    // Color section: color scheme
    $wp_customize->add_setting( 'quizumba_color_scheme', array(
        'default'    => 'dark',
        'transport'  => 'postMessage'
    ) );

    $wp_customize->add_control( 'quizumba_color_scheme', array(
        'label'    => __( 'Color Scheme', 'quizumba' ),
        'section'  => 'colors',
        'type'     => 'radio',
        'choices'  => array( 'light' => __( 'Light', 'quizumba' ), 'dark' => __( 'Dark', 'quizumba' ) ),
        'priority' => 5,
        'setting' => 'quizumba_color_scheme'
    ) );

    // Slider
	$wp_customize->add_section( 'quizumba_slider', array(
			'title'    => __( 'Slider', 'quizumba' ),
			'priority' => 30,
	) );
	$wp_customize->add_setting( 'quizumba_display_slider', array(
			'capability' => 'edit_theme_options',
	) );
	 
	$wp_customize->add_control( 'quizumba_display_slider', array(
			'label'    => __( 'Exibe o slider na página principal', 'quizumba' ),
			'section'  => 'quizumba_slider',
			'type'     => 'checkbox',
			'settings' => 'quizumba_display_slider'
	) );

	// Comments FB
	$wp_customize->add_section( 'quizumba_fb_comments', array(
			'title'    => __( 'Comentários via Facebook', 'quizumba' ),
			'priority' => 30,
	) );
	$wp_customize->add_setting( 'quizumba_display_fb_comments', array(
			'capability' => 'edit_theme_options',
	) );
	
	$wp_customize->add_control( 'quizumba_display_fb_comments', array(
			'label'    => __( 'Exibe a caixa de comentários do Facebook', 'quizumba' ),
			'section'  => 'quizumba_fb_comments',
			'type'     => 'checkbox',
			'settings' => 'quizumba_display_fb_comments'
	) );


}
add_action( 'customize_register', 'quizumba_customize_register' );

/**
 * Get 'quizumba_logo' ID and use it to define the default logo size
 * 
 * @param  string $value The attachment guid, which is the full imagem URL
 * @return string $value The new image size for 'quizumba_logo'
 */
function quizumba_get_customizer_logo_size( $value ) {
    global $wpdb;
	if(!empty( $value) )
	{
	    if ( ! is_numeric( $value ) ) {
	        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid = %s ORDER BY post_date DESC LIMIT 1;", $value ) );
	        if ( ! is_wp_error( $attachment_id ) && wp_attachment_is_image( $attachment_id ) )
	            $value = $attachment_id;
	    }
	
	    $image_attributes = wp_get_attachment_image_src( $value, 'archive' );
	    $value = $image_attributes[0];
	}

    return $value;
}

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
        <?php if ( get_theme_mod( 'quizumba_display_header_text' ) === false ) : ?>
            /* Header text */
            .site-title,
            .site-description {
                    clip: rect(1px, 1px, 1px, 1px);
                    position: absolute;
            }
        <?php else : ?>
            .site-title,
            .site-description {
                    clip: auto;
                    position: relative;
            }
        <?php endif; ?>

	    <?php
	    $link_color = get_theme_mod( 'quizumba_link_color' );
        if ( ! empty( $link_color ) && $link_color != '#d6812c' ) : ?>
            .site-content a,
            .site-content a:visited,
            .site-content a:hover,
            .site-content a:active,
            .site-content a:focus,
            .site-footer a,
            .site-footer a:hover,
            .site-footer a:visited,
            .site-footer a:active {
                color: <?php echo $link_color; ?>
            }

            .main-navigation,
            .main-navigation .children {
                background-color: <?php echo $link_color; ?>
            }

            .site-footer {
            	border-color: <?php echo $link_color; ?>
            }
   		<?php endif; ?>

        <?php
        $color_scheme = get_theme_mod( 'quizumba_color_scheme' );
        if ( isset( $color_scheme ) && $color_scheme == 'light' ) : ?>
            .site-header,
            .site-footer {
                    background-color: #fff;
            }

            .site-header a,
            .site-description,
            .menu-toggle,
            .site-footer {
                color: #000;
            }
        <?php endif; ?>
        <?php
        $header_image = get_theme_mod( 'header_image' );
        if ( isset( $header_image ) && ! empty( $header_image ) && $header_image != "remove-header" ) : ?>
            .site-branding {
            	background-image: url( <?php echo $header_image; ?> );
            	background-position: center center;
    			min-height: 250px;
            }
        <?php endif; ?>
    </style> 
    <!-- / Customizer options -->
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
