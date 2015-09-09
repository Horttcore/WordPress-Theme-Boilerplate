<?php
/**
 * ajax
 *
 * This file is for functions that are hooked by ajax
 *
 * @package WordPress Theme Boilerplate
 * @author Ralf Hortt <hello@horttcore.de>
 **/



if ( !function_exists( 'submit_contact_form' ) ) :
/**
 * Contact form handler
 *
 * @author Ralf Hortt
 **/
function submit_contact_form()
{
	if ( !wp_verify_nonce( $_POST['contact-form-nonce'], 'submit-contact-form' ) )
		die( '<div class="message error"><p>' . __( 'Ihre Anfrage konnte nicht verschickt werden.', 'TEXTDOMAIN' ) . '</p></div>' );

	$headers = "FROM:" . get_bloginfo( 'blogname' ) . ' <' . sanitize_email( get_bloginfo( 'admin_email' ) ) . '>' . "\n";
	$headers.= "REPLY-TO: " . sanitize_text_field( $_POST['contact-name'] ) . ' <' . sanitize_email( $_POST['email'] ) . '>' . "\n";

	$to = get_bloginfo( 'admin_email' );

	$subject = '[' . get_bloginfo( 'blogname' ) . '] ' . __( 'Kontaktformular', 'TEXTDOMAIN' );

	$text = "Name: " .  sanitize_text_field( $_POST['contact-name'] ) . "\n";
	$text .= "E-Mail: " .  sanitize_text_field( $_POST['email'] ) . "\n";
	$text .= "Telefon: " .  sanitize_text_field( $_POST['phone'] ) . "\n";
	$text .= "\nNachricht:\n " .  esc_html( $_POST['message'] ) . "\n\n";

	wp_mail( $to, $subject, $text, $headers );
	wp_mail( sanitize_email( $_POST['email'] ), $subject, "Vielen Dank für Ihre Nachricht,\n\nhiermit erhalten Sie eine Kopie mit den von Ihnen übermittelten Daten.\n\n" . $text, $headers );

	die( '<div class="response success"><p>' . __( 'Vielen Dank für Ihre Nachricht', 'TEXTDOMAIN' ) . '</p></div>' );
}
endif;
add_action( 'wp_ajax_nopriv_submit-contact-form', 'submit_contact_form' );
add_action( 'wp_ajax_submit-contact-form', 'submit_contact_form' );
