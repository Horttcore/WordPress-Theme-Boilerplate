<footer class="footer">

    <div class="footer__container container">

        <?php
        wp_nav_menu(array(
            'theme_location'    => 'footer',
            'container'         => 'nav',
            'container_class'   => 'footer-navigation',
            'container_id'      => 'footer-navigation',
            'menu_class'        => '',
            'menu_id'           => '',
            'before'            => '',
            'fallback_cb'       => '',
        ));
        ?>

    </div>

</footer>
