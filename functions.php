<?php
/**
 * INCLUDES
 */
include 'includes/ajax.php';
include 'includes/locale.php';
include 'includes/login.php';
include 'includes/mail.php';
include 'includes/menus.php';
include 'includes/shortcodes.php';
include 'includes/sidebars.php';
include 'includes/template-tags.php';
include 'includes/customizer/index.php';
include 'includes/plugins/index.php';
include 'includes/widgets/index.php';



/**
 *
 * Support
 *
 */
add_theme_support( 'post-thumbnails' );



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
 * @author Ralf Hortt
 * @since v1.0.0
 **/
function theme_init()
{
	if ( !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) :
		wp_enqueue_script( 'theme', get_stylesheet_directory_uri() . '/scripts/scripts.combined.min.js', array( 'jquery' ), FALSE, TRUE );
		wp_enqueue_style( 'theme', get_stylesheet_directory_uri() . '/styles/styles.min.css' );
	endif;
}
endif;
add_action( 'init', 'theme_init' );
