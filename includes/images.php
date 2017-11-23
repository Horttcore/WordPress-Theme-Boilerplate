<?php
/**
 * Add custom image sizes
 *
 * @package SHW Golden Spices
 * @author Ralf Hortt <me@horttcore.de>
 **/
global $theme_image_sizes;

$theme_image_sizes = array(
    /*
	array(
		'name' => '',
		'label' => __( 'Name', 'TEXTDOMAIN' ),
		'width' => ,
		'height' => ,
		'crop' => TRUE,
	),
	*/
);

if (!$theme_image_sizes) {
    return;
}



foreach ($theme_image_sizes as $theme_image_size) :
    add_image_size( $theme_image_size['name'], $theme_image_size['width'], $theme_image_size['height'], $theme_image_size['crop'] );
endforeach;



/**
 * Add custom image sizes to dropdown
 *
 * @param array $sizes Image sizes
 * @return array Image Sizes
 */
function theme_image_size_names_choose($sizes)
{

    global $theme_image_sizes;

    if (!$theme_image_sizes) {
        return $sizes;
    }

    foreach ($theme_image_sizes as $theme_image_size) :
        $addsizes = array(
            $theme_image_size['name'] => $theme_image_size['label'],
        );

        $sizes = array_merge( $sizes, $addsizes );
    endforeach;

    return $sizes;
}
add_filter('image_size_names_choose', 'theme_image_size_names_choose');
