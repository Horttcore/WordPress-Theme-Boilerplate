<?php
/**
 *
 * Custom background
 *
 * @since v1.0.15
 */

add_theme_support( 'custom-background', array(
	'default-color'          => '',
	'default-image'          => '',
	'wp-head-callback'       => 'theme_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
) );



/**
 *
 * Cutom background callback
 *
 * Sets the background image in the html element
 * background image should sit in the highest priority
 *
 * @since v1.0.15
 * @see wp-includes/theme.php
 * @author Ralf Hortt
 **/
function theme_custom_background_cb()
{
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_theme_mod( 'background_color' );

	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}
	?>
	<style type="text/css" id="custom-background-css">
		<?php echo apply_filters( 'custom-background-element', 'html' ) ?> { <?php echo trim( $style ); ?> }
	</style>
	<?php
}
