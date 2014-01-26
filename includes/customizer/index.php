<?php
/**
 *
 * Load customizers
 *
 */

$customizers = array(
	'customizer-background' => 'customizer.custom-background.php',
	'customizer-contact' => 'customizer.contact.php',
);

if ( !is_array( $customizers ) )
	return;

foreach ( $customizers as $customizer_id => $customizer_file ) :

	if ( TRUE === apply_filters( 'supports-' . $customizer_id, TRUE ) )
		include( $customizer_file );

endforeach;
