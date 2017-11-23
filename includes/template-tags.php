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
		<nav class="content-nav cf">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Ältere Beiträge', 'TEXTDOMAIN' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Neuere Beiträge <span class="meta-nav">&rarr;</span>', 'TEXTDOMAIN' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif;
