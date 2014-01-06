/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Display header text
	wp.customize( 'quizumba_display_header_text', function( value ) {
        value.bind( function( to ) {
            console.log(to);
            if ( false === to ) {
                $( '.site-title, .site-description' ).css( {
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                } );
            } else {
                $( '.site-title, .site-description' ).css( {
                    'clip': 'auto',
                    'position': 'relative'
                } );
            }
        } );
    } );

	// Link color
    wp.customize( 'quizumba_link_color', function( value ) {
        value.bind( function( to ) {
            $( 'a' ).css( 'color', to );
            $( '.site-header' ).css( 'border-color', to );
            $( '.site-footer' ).css( 'border-color', to );
        } );
    } );
} )( jQuery );
