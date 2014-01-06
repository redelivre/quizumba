<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Quizumba
 */

/**
 * Check if the page is intended to use Masonry
 * 
 * @return bool Whether the page is intended to use Masonry or not
 */
function quizumba_page_uses_masonry() {
	if ( is_home() || is_search() || is_archive() || is_post_type_archive() ) {
		return true;
	}
	else {
		return false;
	}
}

if ( ! function_exists( 'quizumba_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function quizumba_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'quizumba' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'quizumba' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'quizumba' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'quizumba_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function quizumba_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'quizumba' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'quizumba' ) ); ?>
			<?php next_post_link(     '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'quizumba' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'quizumba_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function quizumba_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'quizumba' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'quizumba' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'quizumba' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'quizumba' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'quizumba' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'quizumba' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for quizumba_comment()

if ( ! function_exists( 'quizumba_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function quizumba_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'quizumba' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function quizumba_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so quizumba_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so quizumba_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in quizumba_categorized_blog.
 */
function quizumba_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'quizumba_category_transient_flusher' );
add_action( 'save_post',     'quizumba_category_transient_flusher' );

/**
 * Create a container with post format info
 *
 * @uses  get_post_format() 
 */
function quizumba_the_post_format() {
	$format = get_post_format();

	if ( $format ) { ?>
		<div class="entry-meta entry-meta--format">
			<?php echo $format; ?>
		</div><!-- .entry-meta--format -->
	<?php
	}
}

/**
 * List all the post categories
 *
 * @uses  quizumba_categorized_blog()
 */
function quizumba_the_category_list() {

	if ( ! quizumba_categorized_blog() )
		return;

	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( ', ', 'quizumba' ) );

	if ( $category_list ) : ?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'quizumba' ), $category_list ); ?>
		</span>
	<?php
	endif; // if $category_list

}

/**
 * List all the post tags
 *
 * @uses  quizumba_categorized_blog()
 */
function quizumba_the_tag_list() {

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( ', ', 'quizumba' ) );

	if ( $tag_list ) : ?>
		<span class="tag-links">
			<?php printf( __( 'Tagged %1$s', 'quizumba' ), $tag_list ); ?>
		</span>
	<?php endif; // if $tag_list
	
}

/**
 * Retrieve galleries from the passed post's content
 * 
 * @todo This is a copy from get_post_galleries() function, available in WP 3.6. We
 *       need to update Rede Livre as soon as possible
 *
 * @since Quizumba 1.0
 *
 * @param mixed $post Optional. Post ID or object.
 * @param boolean $html Whether to return HTML or data in the array
 * @return array A list of arrays, each containing gallery data and srcs parsed
 *                from the expanded shortcode
 */
function quizumba_get_post_galleries( $post, $html = true ) {
	global $post;

    $galleries = array();
    if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $srcs = array();
                $count = 1;

                $gallery = do_shortcode_tag( $shortcode );
                if ( $html ) {
                        $galleries[] = $gallery;
                } else {
                    preg_match_all( '#src=([\'"])(.+?)\1#is', $gallery, $src, PREG_SET_ORDER );
                    if ( ! empty( $src ) ) {
                            foreach ( $src as $s )
                                    $srcs[] = $s[2];
                    }

                    $data = shortcode_parse_atts( $shortcode[3] );
                    $data['src'] = array_values( array_unique( $srcs ) );
                    $galleries[] = $data;
                }
            }
        }
    }

    return apply_filters( 'quizumba_get_post_galleries', $galleries, $post );

}

/**
 * Check a specified post's content for gallery and, if present, return the first
 *
 * @todo This is a copy from get_post_galleries() function, available in WP 3.6. We
 *       need to update Rede Livre as soon as possible
 *
 * @since Quizumba 1.0
 *
 * @param mixed $post Optional. Post ID or object.
 * @param boolean $html Whether to return HTML or data
 * @return string|array Gallery data and srcs parsed from the expanded shortcode
 */
function quizumba_get_post_gallery( $post = 0, $html = true ) {
    $galleries = quizumba_get_post_galleries( $post, $html );
    $gallery = reset( $galleries );

    return apply_filters( 'quizumba_get_post_gallery', $gallery, $post, $galleries );
}