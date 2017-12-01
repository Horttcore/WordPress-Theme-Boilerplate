<?php
/**
 * Localization
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Translations
{

    /**
     * Register WordPress hooks
     *
     */
    public function __construct()
    {
        add_action( 'after_setup_theme', [$this, 'loadTranslation'] );
    }


    /**
     * Load translation
     *
     * @return bool
     */
    public function loadTranslation():bool
    {
        return $this->translated = load_theme_textdomain( 'TEXTDOMAIN', get_template_directory() . '/languages' );
    }

}
