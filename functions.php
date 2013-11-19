<?php
/**
 *
 * DEFINES
 *
 */
define( 'ATTACHMENTS_DEFAULT_INSTANCE', false );



/**
 *
 * Support
 *
 */
add_theme_support( 'post-thumbnails' );
register_nav_menus( array( 'main' => 'Hauptmenü', 'footer' => 'Footermenü' ) );
register_sidebar( array( 'name' => __( 'Sidebar' ), 'id' => 'sidebar' ) );



if ( !function_exists( 'shortcode_kontakt' ) ) :
/**
 * Shortcode [KONTAKT]
 *
 * @return void
 * @author Ralf Hortt
 **/
function shortcode_kontakt( $atts = array() )
{
	extract( shortcode_atts( array(
		'class' => 'contact-form',
		'id' => false
	), $atts ) );

	$output = '<form class="contact-form" class="clearfix ' . $class . '">';
	$output.= '<p><label for="contact-name">' . __( 'Ihr Name:', 'TEXTDOMAIN' ) . '*</label><input name="contact-name" type="text" class="required contact-name" id="contact-name" data-error="' . __( 'Das Feld Name ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></p>';
	$output.= '<p><label for="email">' . __( 'Ihre E-Mail Adresse:', 'TEXTDOMAIN' ) . '*</label><input name="email" type="text" class="required email" id="email" data-error="' . __( 'Das Feld E-Mail ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></p>';
	$output.= '<p><label for="phone">' . __( 'Ihre Telefonnummer:', 'TEXTDOMAIN' ) . '*</label><input name="phone" type="text" class="required phone" id="phone" data-error="' . __( 'Das Feld Telefon ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></p>';
	$output.= '<p><label for="message">' . __( 'Ihre Nachricht:', 'TEXTDOMAIN' ) . '*</label><textarea name="message" class="required" id="message" data-error="' . __( 'Das Feld Nachricht ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></textarea></p>';
	$output.= '<p class="submit"><button type="submit"><i class="icon-envelope-alt"></i> ' . __( 'Senden', 'TEXTDOMAIN' ) . '</button></p>';
	$output.= '<input type="hidden" name="action" value="submit-contact-form">';
	$output.= wp_nonce_field( 'submit-contact-form', 'contact-form-nonce', TRUE, FALSE );
	$output.= '</form>';

	return $output;
}
endif;
add_shortcode( 'KONTAKTFORMULAR', 'shortcode_kontakt' );



if ( !function_exists( 'submit_contact_form' ) ) :
/**
 * Kontaktformular
 *
 * @return void
 * @author Ralf Hortt
 **/
function submit_contact_form()
{
	if ( !wp_verify_nonce( $_POST['contact-form-nonce'], 'submit-contact-form' ) )
		die( '<div class="message error"><p>' . __( 'Ihre Anfrage konnte nicht verschickt werden.', 'TEXTDOMAIN' ) . '</p></div>' );

	$headers = "FROM:" . get_bloginfo( 'blogname' ) . '<' . sanitize_email( get_bloginfo( 'admin_email' ) ) . '>' . "\n";
	$headers.= "REPLY-TO: " . sanitize_text_field( $_POST['contact-name'] ) . '<' . sanitize_email( $_POST['email'] ) . '>' . "\n";

	$to = get_bloginfo( 'admin_email' );

	$subject = '[' . get_bloginfo( 'blogname' ) . '] Kontaktformular';

	$text = "Name: " .  sanitize_text_field( $_POST['contact-name'] ) . "\n";
	$text .= "E-Mail: " .  sanitize_text_field( $_POST['email'] ) . "\n";
	$text .= "Thema: " .  sanitize_text_field( $_POST['subject'] ) . "\n";
	$text .= "Aufmerksam durch: " .  sanitize_text_field( $_POST['attentive'] ) . "\n";
	$text .= "\nNachricht:\n " .  esc_html( $_POST['message'] ) . "\n\n";

	wp_mail( $to, $subject, $text, $headers );
	wp_mail( sanitize_email( $_POST['email'] ), $subject, "Vielen Dank für Ihre Nachricht,\n\nhiermit erhalten Sie eine Kopie mit den von Ihnen übermittelten Daten.\n\n" . $text, $headers );

	die( '<div class="response success"><p>' . __( 'Vielen Dank für Ihre Nachricht', 'TEXTDOMAIN' ) . '</p></div>' );
}
endif;
add_action( 'wp_ajax_nopriv_submit-contact-form', 'submit_contact_form' );
add_action( 'wp_ajax_submit-contact-form', 'submit_contact_form' );



if ( !function_exists( 'theme_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @return void
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



if ( !function_exists( 'theme_init' ) ) :
/**
 * Theme init
 *
 * @return void
 * @author Ralf Hortt
 **/
function theme_init()
{
	if ( !is_admin() && !in_array($GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' )) ) :
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
function theme_login_headerurl($url) {
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



if ( !function_exists( 'theme_slider' ) ) :
/**
 * Attachments Slider
 *
 * @param obj $attachments Attachments object
 * @since 1.0.0
 * @author Ralf Hortt
 **/
function theme_slider( $attachments )
{
	$attachments->register( 'slider', array(

		// title of the meta box (string)
		'label'			=> _( 'Slideshow', 'TEXTDOMAIN' ),

		// all post types to utilize (string|array)
		'post_type'		=> array( 'page' ),

		// allowed file type(s) (array) (image|video|text|audio|application)
		'filetype'		=> 'image',	// no filetype limit

		// include a note within the meta box (string)
		//'note'			=> __( 'Note', 'TEXTDOMAIN' ),

		// text for 'Attach' button in meta box (string)
		'button_text'	=> __( 'Slide hinzufügen', 'TEXTDOMAIN' ),

		// text for modal 'Attach' button (string)
		'modal_text'	=> __( 'Hinzufügen', 'TEXTDOMAIN' ),

		/**
		 * Fields for the instance are stored in an array. Each field consists of
		 * an array with three keys: name, type, label.
		 *
		 * name	- (string) The field name used. No special characters.
		 * type	- (string) The registered field type. Fields available: text, textarea
		 * label - (string) The label displayed for the field.
		 */
		'fields'				=> array(
			array(
				'name'	=> 'caption',										// unique field name
				'type'	=> 'text',											// registered field type
				'label' => __( 'Bildunterschrift', 'TEXTDOMAIN' ),	// label to display
			),
		),

	) ); // unique instance name
}
endif;
add_action( 'attachments_register', 'theme_slider' );
