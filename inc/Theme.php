<?php
/**
 * Theme configuration
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

use Horttcore\WP_SLUG\Assets;
use Horttcore\WP_SLUG\Customizer;
use Horttcore\WP_SLUG\Features;
use Horttcore\WP_SLUG\Helpers;
use Horttcore\WP_SLUG\Images;
use Horttcore\WP_SLUG\Mail;
use Horttcore\WP_SLUG\Menus;
use Horttcore\WP_SLUG\Optimizations;
use Horttcore\WP_SLUG\Sidebars;
use Horttcore\WP_SLUG\Translations;

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
        $this->assets->addScript( 'theme', 'dist/js/scripts.min.js' );
        $this->assets->addStyle( 'theme', 'dist/css/styles.combined.min.css' );

        # Customizer
        $this->customizer = new Customizer;
        $this->customizer->addPanel( 'settings', __('Einstellungen', 'TEXTDOMAIN') );
        $this->customizer->addSection( 'contact', __('Kontaktdaten', 'TEXTDOMAIN'), 'settings');
        $this->customizer->addOption( 'company', __( 'Firma', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'street', __( 'Straße', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'street-number', __( 'Nr', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'zip', __( 'PLZ', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'city', __( 'Stadt', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'phone', __( 'Telefon', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'mobile', __( 'Mobil', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'fax', __( 'Fax', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'mail', __( 'E-Mail', 'TEXTDOMAIN' ), 'contact' );
        $this->customizer->addOption( 'website', __( 'Website', 'TEXTDOMAIN' ), 'contact' );

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
