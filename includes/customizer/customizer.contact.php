<?php
/**
 * Customizer
 *
 * @param obj $wp_customize WordPress Customizer
 * @since v1.0
 * @author Ralf Hortt
 */
if ( !function_exists( 'theme_customizer_address' ) ) :
function theme_customizer_address( $wp_customize )
{

	$settings = array(
		'company' => __( 'Firma', 'diro' ),
		'street' => __( 'Straße', 'diro' ),
		'street-number' => __( 'Nr', 'diro' ),
		'zip' => __( 'PLZ', 'diro' ),
		'city' => __( 'Stadt', 'diro' ),
		'phone' => __( 'Telefon', 'diro' ),
		'fax' => __( 'Fax', 'diro' ),
		'email' => __( 'E-Mail', 'diro' ),
	);

	$wp_customize->add_section( 'address' , array(
		'title'		=> __( 'Adresse', 'diro' ),
		'priority'	=> 100,
	) );

	if ( $settings ) :

		$i = 1;

		foreach ( $settings as $setting => $label ) :

			$wp_customize->add_setting( 'contact-' . $setting, array(
				'transport'	=> 'refresh',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact-' . $setting, array(
				'label'		=> $label,
				'section'	=> 'address',
				'settings'	=> 'contact-' . $setting,
				'priority'  => $i
			) ) );

			$i ++;

		endforeach;

	endif;

}
endif;
add_action( 'customize_register', 'theme_customizer_address' );