<?php
/**
 * Customizer
 *
 * @param obj $wp_customize WordPress Customizer
 * @since v1.0.14
 * @author Ralf Hortt
 */
if ( !function_exists( 'theme_customizer_address' ) ) :
function theme_customizer_address( $wp_customize )
{

	$settings = array(
		'company' => __( 'Firma', 'TEXTDOMAIN' ),
		'street' => __( 'Straße', 'TEXTDOMAIN' ),
		'street-number' => __( 'Nr', 'TEXTDOMAIN' ),
		'zip' => __( 'PLZ', 'TEXTDOMAIN' ),
		'city' => __( 'Stadt', 'TEXTDOMAIN' ),
		'phone' => __( 'Telefon', 'TEXTDOMAIN' ),
		'fax' => __( 'Fax', 'TEXTDOMAIN' ),
		'email' => __( 'E-Mail', 'TEXTDOMAIN' ),
		'url' => __( 'URL', 'TEXTDOMAIN' ),
	);

	$wp_customize->add_section( 'address' , array(
		'title'		=> __( 'Kontakt', 'TEXTDOMAIN' ),
		'priority'	=> 100,
	) );

	if ( $settings ) :

		$i = 1;

		foreach ( $settings as $setting => $label ) :

			$wp_customize->add_setting( $setting, array(
				'transport'	=> 'refresh',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting, array(
				'label'		=> $label,
				'section'	=> 'address',
				'settings'	=> $setting,
				'priority'  => $i
			) ) );

			$i ++;

		endforeach;

	endif;

}
endif;
add_action( 'customize_register', 'theme_customizer_address' );
