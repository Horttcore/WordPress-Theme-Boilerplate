<?php
/**
 *
 * Load shortcodes
 *
 */

$shortcodes = array(
    'class.shortcode.form.contact.php',
);

if (empty( $shortcodes )) :
    return;
endif;

foreach ($shortcodes as $shortcode) :
    require($shortcode);
endforeach;
