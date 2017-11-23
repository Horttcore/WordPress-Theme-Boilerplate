<?php
/**
 * Head
 *
 * This file is for functions that are hooked to wp_head
 *
 * @package WordPress Theme Boilerplate
 * @author Ralf Hortt <hello@horttcore.de>
 **/



if (!function_exists( 'theme_ajax_url' )) :
/**
 * Publish ajaxurl
 *
 * @author Ralf Hortt
 **/
    function theme_ajax_url()
    {
        ?>
        <script type="text/javascript">var ajaxurl = '<?php echo apply_filters( 'theme_ajax_url', admin_url( 'admin-ajax.php' ) ); ?>';</script>
        <?php
    }
endif;
add_action( 'wp_head', 'theme_ajax_url' );



// Remove generator meta tag
remove_action( 'wp_head', 'wp_generator' );

// Remove version
add_filter( 'the_generator', '__return_null' );

// Remove the EditURI/RSD link
remove_action ('wp_head', 'rsd_link');

// Remove wlwmanifest
remove_action( 'wp_head', 'wlwmanifest_link');

// Remove shorturl
remove_action( 'wp_head', 'wp_shortlink_wp_head');
