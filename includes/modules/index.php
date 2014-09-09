<?php
/**
*
* Load modules
*
*/

$modules = array(
	'template-meta-boxes' => 'template-meta-boxes/template-meta-boxes.php',
);

if ( !is_array( $modules ) )
	return;

foreach ( $modules as $module_id => $module_file ) :

	if ( TRUE === apply_filters( 'supports-' . $module_id, TRUE ) )
		include( $module_file );

endforeach;
