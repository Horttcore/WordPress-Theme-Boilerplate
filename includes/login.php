<?php
/**
 *
 * Login
 *
 */

if ( !function_exists( 'theme_login_headerurl' ) ) :
/**
 * Login logo URL
 *
 * @param str $url URL
 * @return str URL
 * @author Ralf Hortt
 **/
function theme_login_headerurl( $url )
{
	return get_bloginfo( 'wpurl' );
}
endif;
add_filter( 'login_headerurl', 'theme_login_headerurl' );



if ( !function_exists( 'theme_login_style' ) ) :
/**
 * Theme login style
 *
 * @author Ralf Hortt
 */
function theme_login_style()
{
	?><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/css/login.min.css"><?php
}
endif;
add_action( 'login_head', 'theme_login_style' );