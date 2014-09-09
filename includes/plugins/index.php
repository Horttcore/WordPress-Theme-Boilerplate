<?php
/**
 *
 * Load customizers
 *
 */

$plugins = array(
	'attachments' => 'attachments.php',
	'custom-background-image-size' => 'custom-background-image-size.php',
	'multiple-post-thumbnails' => 'multiple-post-thumbnails.php',
);

if ( !is_array( $plugins ) )
	return;

foreach ( $plugins as $plugin_id => $plugin_file ) :

	if ( TRUE === apply_filters( 'supports-' . $plugin_id, TRUE ) )
		include( $plugin_file );

endforeach;
