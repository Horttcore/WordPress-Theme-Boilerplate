<?php
/**
 * Theme configuration
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

/**
 * Class Theme
 *
 * Class for configuring the theme
 *
 * @package Horttcore\WP_SLUG
 */
class Theme
{

    /**
     * Runs the filters and actions.
     */
    public function init()
    {

        # Assets
        $this->assets = new Assets();
        $this->assets->addScript( 'theme', '/dist/js/scripts.min.js' );
        $this->assets->addStyle( 'theme', '/dist/css/styles.combined.min.css' );

        # Customizer
        $this->customizer = new Customizer;
        $this->customizer->addPanel('settings', __('Einstellungen', 'TEXTDOMAIN'));

        $this->customizer->addSection('contact', __('Kontaktdaten', 'TEXTDOMAIN'), 'settings', ['option_type' => 'option']);
        $this->customizer->addOption('company', __('Firma', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('street', __('Straße', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('street-number', __('Nr', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('zip', __('PLZ', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('city', __('Stadt', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('phone', __('Telefon', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('mobile', __('Mobil', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('fax', __('Fax', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('mail', __('E-Mail', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);
        $this->customizer->addOption('website', __('Website', 'TEXTDOMAIN'), 'contact', ['option_type' => 'option']);

        // Features
        $this->features = new Features([
    		// 'automatic-feed-links',
    		// 'custom-background',
    		// 'custom-header',
    		'custom-logo',
    		'html5' => ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption'],
    		'post-thumbnails',
    		'title-tag',
        ]);

        # Image sizes
        $this->imageSizes = new Images([
            /*
            [
                'name' => 'name',
        		'label' => __( 'Label', 'TEXTDOMAIN' ),
        		'width' => 100,
        		'height' => 100,
        		'crop' => TRUE,
            ]
            */
        ]);

        # Menus
        $this->menus = new Menus([
            'meta' => __( 'Metamenü', 'TEXTDOMAIN' ),
            'main' => __( 'Hauptmenü', 'TEXTDOMAIN' ),
            'footer' => __( 'Footermenü', 'TEXTDOMAIN' ),
        ]);

        # Sidebars
        $this->sidebars = new Sidebars([
            __( 'Sidebar', 'TEXTDOMAIN' )
        ]);

        # Optimizations
        $this->optimizations = new Optimizations;

        # Translation
        $this->translations = new Translations;
    }
}
