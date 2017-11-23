<?php
/**
 *
 * Load plugin files
 *
 */

$plugins = array(
    'kirki.php',
);

if (empty( $plugins )) :
    return;
endif;

foreach ($plugins as $plugin) :
    require($plugin);
endforeach;
