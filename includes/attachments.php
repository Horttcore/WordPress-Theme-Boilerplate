<?php
/**
 *
 * Attachments plugin configuration
 *
 */

define( 'ATTACHMENTS_DEFAULT_INSTANCE', false );
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
		'label'			=> __( 'Slideshow', 'TEXTDOMAIN' ),

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
