<?php
if ( !class_exists( 'Custom_Background_Image_Size' ) )
	return;


/**
 * Change background image selector
 *
 * @param str $selector Background image selector
 * @return str Background image selector
 * @since v1.0.15
 * @author Ralf Hortt
 **/
function theme_background_image_selector()
{
	return 'html.custom-background';
}
add_filter( 'background-image-selector', 'theme_background_image_selector' );