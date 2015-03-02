<?php
/**
 *
 * Shortcodes
 *
 */

if ( !function_exists( 'shortcode_kontakt' ) ) :
/**
 * Shortcode [KONTAKT]
 *
 * @param array $atts Attributes
 * @return str HTML output
 * @author Ralf Hortt
 **/
function shortcode_kontakt( $atts = array() )
{
	extract( shortcode_atts( array(
		'class' => 'contact-form',
		'id' => false
	), $atts ) );

	$output = '<form class="contact-form" class="cf ' . $class . '">';
	$output.= '<p><label for="contact-name">' . __( 'Ihr Name:', 'TEXTDOMAIN' ) . '*</label><input name="contact-name" type="text" class="required contact-name" id="contact-name" data-error="' . __( 'Das Feld Name ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></p>';
	$output.= '<p><label for="email">' . __( 'Ihre E-Mail Adresse:', 'TEXTDOMAIN' ) . '*</label><input name="email" type="text" class="required email" id="email" data-error="' . __( 'Das Feld E-Mail ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></p>';
	$output.= '<p><label for="phone">' . __( 'Ihre Telefonnummer:', 'TEXTDOMAIN' ) . '*</label><input name="phone" type="text" class="required phone" id="phone" data-error="' . __( 'Das Feld Telefon ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></p>';
	$output.= '<p><label for="message">' . __( 'Ihre Nachricht:', 'TEXTDOMAIN' ) . '*</label><textarea name="message" class="required" id="message" data-error="' . __( 'Das Feld Nachricht ist ein Pflichtfeld', 'TEXTDOMAIN' ) . '"></textarea></p>';
	$output.= '<p class="submit"><button type="submit"> ' . __( 'Absenden', 'TEXTDOMAIN' ) . '</button></p>';
	$output.= '<input type="hidden" name="action" value="submit-contact-form">';
	$output.= wp_nonce_field( 'submit-contact-form', 'contact-form-nonce', TRUE, FALSE );
	$output.= '</form>';

	return $output;
}
endif;
add_shortcode( 'KONTAKTFORMULAR', 'shortcode_kontakt' );