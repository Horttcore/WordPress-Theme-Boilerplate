<?php
/**
 * Add custom image sizes
 *
 * @package SHW Golden Spices
 * @author Ralf Hortt <me@horttcore.de>
 **/
namespace Horttcore\WP_SLUG;

class Images
{


    /**
     * Class constructor
     *
     * Usage: Array of image sizes
     * [
     *    'name' => '',
     *    'label' => __( 'Name', 'TEXTDOMAIN' ),
     *    'width' => ,
     *    'height' => ,
     *    'crop' => TRUE,
     * ]
     *
     * @param array $config Image configs
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        add_filter('image_size_names_choose', [$this, 'addToImageDropDown'] );
        add_action('after_setup_theme', [$this, 'registerImageSizes']);
    }


    /**
     * Add images to dropdowns
     *
     * @param array $sizes Image sizes
     * @return array Image Sizes
     */
    public function addToImageDropDown($sizes)
    {

        foreach ($this->config as $imageSize) :
            $sizes = array_merge( $sizes, [
                $imageSize['name'] => $imageSize['label'],
            ] );
        endforeach;

        return $sizes;
    }



    /**
     * Register image sizes
     *
     * @access protected
     * @return void
     */
    public function registerImageSizes()
    {
        foreach ($this->config as $imageSize) :
            add_image_size( $imageSize['name'], $imageSize['width'], $imageSize['height'], $imageSize['crop'] );
        endforeach;
    }
}
