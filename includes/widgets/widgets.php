<?php
/**
 * Init Widgets
 *
 * @author Ralf Hortt
 **/
function theme_widgets_init()
{
	/**
	 * Class name => file
	 */
	$widgets = array(
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
add_action( 'widgets_init', 'theme_widgets_init' );
