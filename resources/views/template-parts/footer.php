<footer class="footer">
    <div class="footer__container">
        <?php
        wp_nav_menu([
            'theme_location' => 'footer',
            'container' => 'nav',
            'container_class' => 'footer-navigation',
            'container_id' => 'footer-navigation',
            'menu_class' => '',
            'menu_id' => '',
            'before' => '',
            'fallback_cb' => '',
        ]);
        ?>
    </div>
</footer>
