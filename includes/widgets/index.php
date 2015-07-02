<?php
/**
 * Init widgets
 *
 * @since v1.0.12
 * @author Ralf Hortt
 **/
if ( !function_exists( 'theme_widgets_init' ) ) :
function theme_widgets_init()
{
	/**
	 * Class name => file
	 */
	$widgets = array(
		'WP_Widget_Contact' => 'widget.contact.php',
		'WP_Widget_Subnav' => 'widget.subnav.php',
	);

	if ( !is_array( $widgets ) )
		return;

	foreach ( $widgets as $widget_id => $widget_file ) :

		if ( TRUE === apply_filters( 'supports-' . $widget_id, TRUE ) ) :
			include( $widget_file );
			register_widget( $widget_id );
		endif;

	endforeach;

}
endif;
add_action( 'widgets_init', 'theme_widgets_init' );
