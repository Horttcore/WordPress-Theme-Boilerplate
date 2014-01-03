<?php
/**
 * INCLUDES
 */
include 'includes/ajax.php';
include 'includes/attachments.php';
include 'includes/shortcodes.php';
include 'includes/template-tags.php';



/**
 *
 * Support
 *
 */
add_theme_support( 'post-thumbnails' );
register_nav_menus( array( 'main' => __( 'Hauptmenü', 'TEXTDOMAIN' ), 'footer' => 'Footermenü' ) );
register_sidebar( array( 'name' => __( 'Sidebar', 'TEXTDOMAIN' ), 'id' => 'sidebar' ) );



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



if ( !function_exists( 'theme_init' ) ) :
/**
 * Theme init
 *
 * @return void
 * @author Ralf Hortt
 **/
function theme_init()
{
	if ( !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) :
		wp_enqueue_script( 'theme', get_stylesheet_directory_uri() . '/javascript/theme.min.js', array( 'jquery' ), FALSE, TRUE );
		wp_enqueue_style( 'theme', get_stylesheet_directory_uri() . '/css/theme.min.css' );
	endif;
}
endif;
add_action( 'init', 'theme_init' );



if ( !function_exists( 'theme_login_headerurl' ) ) :
/**
 * Login logo URL
 *
 * @param str $url URL
 * @return str URL
 * @author Ralf Hortt
 **/
function theme_login_headerurl( $url ) {
	return get_bloginfo( 'wpurl' );
}
endif;
add_filter( 'login_headerurl', 'theme_login_headerurl' );



if ( !function_exists( 'theme_nav_menu_css_class' ) ) :
/**
 * Highlight menu item
 *
 * @param array $classes Menu classes
 * @param obj $item Menu item
 * @return array CSS classes
 * @author Ralf Hortt
 **/
function theme_nav_menu_css_class( $classes, $item )
{
	/*
    if (
    	( is_singular( 'post' ) && 'Aktuelles'  ==  $item->title ) ||
    	( is_singular( 'event' ) && 'Termine' == $item->title )
    )
        $classes[] = 'current-menu-ancestor';
    */

    return $classes;
}
endif;
add_filter( 'nav_menu_css_class', 'theme_nav_menu_css_class', 10, 2 );