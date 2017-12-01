<?php
/**
 * WP_TITLE Theme bootstrap
 *
 * @package   Horttcore\WP_SLUG
 * @license   GPL-2.0+
 */

namespace Horttcore\WP_SLUG;

// Load Composer autoloader. From https://github.com/brightnucleus/jasper-client/blob/master/tests/bootstrap.php#L55-L59
$autoloader = dirname( __FILE__ ) . '/vendor/autoload.php';

if (is_readable( $autoloader )) :
    require_once $autoloader;
endif;

if (! defined( 'WPINC' )) :
    die;
endif;

// Create object.
$theme = new Theme();

// Init the theme.
$theme->init();
