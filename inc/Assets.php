<?php
/**
 * Asset management
 *
 * @package Horttcore\WP_SLUG
 */
namespace Horttcore\WP_SLUG;

class Assets
{


    /**
     * Scripts
     *
     * @var array
     */
     protected $scripts =[];


    /**
     * Styles
     *
     * @var array
     */
     protected $style =[];


    /**
     * Setup WordPress hooks
     *
     * @return void
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScript']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyle']);
    }


    /**
     * Enqueue script
     *
     * @param string $handle Script name
     * @param string $source Path for javascript file
     * @param array $dependencies Dependencies
     * @param string $version Version
     * @param bool $inFooter Should the script be enqueued in footer
     * @return void
     */
    public function addScript(string $handle, string $source, array $dependencies = [], string $version = null, bool $inFooter = null):void
    {
        if ( !wp_script_is($handle, 'registered') ) :
            wp_register_script($handle, $this->prefixPath( $source, 'dist/js' ), $dependencies, $version, $inFooter);
        endif;

        $this->scripts[] = $handle;
    }


    /**
     * Enqueue style
     *
     * @param string $handle Script name
     * @param string $source Path for javascript file
     * @param array $dependencies Dependencies
     * @param string $version Version
     * @return void
     */
    public function addStyle(string $handle, string $source, array $dependencies = [], string $version = null):void
    {
        if ( !wp_style_is($handle, 'registered') ) :
            wp_register_style($handle, $this->prefixPath( $source, 'dist/css' ), $dependencies, $version);
        endif;

        $this->styles[] = $handle;
    }


    /**
     * Enqueue scripts
     *
     * @return void
     */
    public function enqueueScript():void
    {
        foreach ( $this->scripts as $script ) :
            wp_enqueue_script( $script );
        endforeach;
    }


    /**
     * Enqueue styles
     *
     * @return void
     */
    public function enqueueStyle():void
    {
        foreach ( $this->styles as $style ) :
            wp_enqueue_style( $style );
        endforeach;
    }


    /**
     * Prefix path
     *
     * @access protected
     * @param type var Description
     * @return return type
     */
    protected function prefixPath($source):string
    {
        return get_stylesheet_directory_uri() . DIRECTORY_SEPARATOR . $source;
    }

}
