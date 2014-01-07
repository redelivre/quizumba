/**
 * Functionality specific to Quizumba
 *
 * Provides helper functions to enhance the theme experience.
 */

jQuery( document ).ready( function() {

    var $container = jQuery('.js-masonry');

    // Masonry
    $container.imagesLoaded( function() {
        $container.masonry( {
            itemSelector: '.hentry',
            columnWidth: '.hentry',
            gutterWidth: 10,
        } );
    } );

    // FitVids
    jQuery( '.entry-content, .widget' ).fitVids();

});