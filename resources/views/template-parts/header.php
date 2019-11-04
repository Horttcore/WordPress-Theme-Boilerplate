<a class="screen-reader-text" href="#main-navigation"><?php _e('Zum Inhalt', 'TEXTDOMAIN') ?></a>
<a class="screen-reader-text" href="#main-navigation"><?php _e('Zum Hauptmenü', 'TEXTDOMAIN') ?></a>

<header class="header" role="banner">

    <div class="header__container container">

        <?php the_custom_logo() ?>

        <button class="navigation-toggle"><span class="navigation-toggle__icon"></span></button>

        <?php
        wp_nav_menu(array(
            'theme_location'    => 'main',
            'container'         => 'nav',
            'container_class'   => 'main-navigation',
            'container_id'      => 'main-navigation',
            'menu_class'        => '',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

        <?php
        wp_nav_menu(array(
            'theme_location'    => 'meta',
            'container'         => 'nav',
            'container_class'   => 'meta-navigation',
            'container_id'      => 'meta-navigation',
            'menu_class'        => '',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

    </div>

</header>
