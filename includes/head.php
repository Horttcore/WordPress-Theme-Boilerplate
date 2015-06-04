<?php
if ( !function_exists( 'theme_favicon' ) ) :
/**
 * Theme favicon
 *
 * @author Ralf Hortt
 **/
function theme_favicon()
{
	?><link rel="icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" /><?php
}
endif;
add_action( 'admin_head', 'theme_favicon' );
add_action( 'wp_head', 'theme_favicon' );