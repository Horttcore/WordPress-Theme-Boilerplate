<?php
/**
 * Kirki Advanced Customizer
 *
 * This is a sample configuration file to demonstrate all fields & capabilities.
 *
 * CAUTION:
 * USE THIS WITH THE DEVELOP BRANCH ON THE GITHUB REPOSITORY:
 * https://github.com/aristath/kirki/tree/develop
 *
 * @package Kirki
 */

/**
 * Create our panels and sections.
 *
 * For this example we'll be creating 2 panels (1 for default WordPress controls and another for our custom controls)
 * and then a separate section for each control type.
 */
function kirki_panels_sections( $wp_customize )
{

	/**
	 * Add panels
	 */
	$wp_customize->add_panel( 'theme', array(
		'priority'    => 10,
		'title'       => __( 'Theme', 'TEXTDOMAIN' ),
		'description' => '',
	) );

	/**
	 * Add sections
	 */
	$wp_customize->add_section( 'contact', array(
		'title'       => __( 'Kontaktdaten', 'TEXTDOMAIN' ),
		'priority'    => 100,
		'panel'       => 'theme',
		'description' => '',
	) );

}
add_action( 'customize_register', 'kirki_panels_sections' );


/**
 * Add our controls.
 */
function kirki_controls( $controls )
{

	$settings = array(
		'company' => __( 'Firma', 'TEXTDOMAIN' ),
		'street' => __( 'Straße', 'TEXTDOMAIN' ),
		'street-number' => __( 'Nr', 'TEXTDOMAIN' ),
		'zip' => __( 'PLZ', 'TEXTDOMAIN' ),
		'city' => __( 'Stadt', 'TEXTDOMAIN' ),
		'phone' => __( 'Telefon', 'TEXTDOMAIN' ),
		'mobile' => __( 'Mobil', 'TEXTDOMAIN' ),
		'fax' => __( 'Mobil', 'TEXTDOMAIN' ),
		'fax' => __( 'Fax', 'TEXTDOMAIN' ),
		'email' => __( 'E-Mail', 'TEXTDOMAIN' ),
		'url' => __( 'URL', 'TEXTDOMAIN' ),
	);

	foreach ( $settings as $setting => $label ) :

		// Header
		$controls[] = array(
			'type'        => 'text',
			'settings'     => $setting,
			'label'       => $label,
			'description' => '',
			'help'        => '',
			'section'     => 'contact',
			'default'     => '',
			'priority'    => 10,
		);

	endforeach;

	return $controls;

}
add_filter( 'kirki/controls', 'kirki_controls' );
