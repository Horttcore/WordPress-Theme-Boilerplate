<?php
/**
 * Theme supports
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Features
{


	/**
	 * Features
	 *
	 * @var string
	 */
	protected $features = [];

	/**
	 * Hook into WordPress
	 *
	 * @param array $features Features
 	 */
	public function __construct( $features = [])
	{

		$this->features = $features;
		add_action( 'after_setup_theme', [$this, 'addThemeSupports']);
	}

	/**
	 * Support
	 *
	 * @return void
	 */
	public function addThemeSupports()
	{

		foreach ( $this->features as $featureTag => $featureConfig  ) :

			if ( is_array( $featureConfig ) ) :
				add_theme_support( $featureTag, $featureConfig );
				continue;
			endif;

			add_theme_support( $featureConfig );

		endforeach;
	}
}
