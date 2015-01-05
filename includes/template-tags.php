<?php
/**
 *
 * Template tags
 *
 */

if ( !function_exists( 'theme_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @author Ralf Hortt
 */
function theme_content_nav() {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav class="content-nav clearfix">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Ältere Beiträge', 'TEXTDOMAIN' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Neuere Beiträge <span class="meta-nav">&rarr;</span>', 'TEXTDOMAIN' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif;



if ( !function_exists( 'theme_pagination' ) ) :
/**
 * Pagination link
 *
 * @author Ralf Hortt
 */
function theme_pagination( $before = '<div class="pagination">', $after = '</div><!-- .pagination -->' )
{
	global $wp_query;

	$big = 999999999; // need an unlikely integer

	$pagination = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	) );

	if ( !$pagination )
		return;

	echo $before . $pagination . $after;

}
endif;