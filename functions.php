<?php
/**
 * ------------------------------------------------------------------------------
 * Theme configuration
 *
 * - Composer autoloader
 * - Adding theme support for features
 * - Register assets
 * - Register menus
 * - Register sidebars
 * - Register image sizes
 * - Register customizer fields
 * - Optimize WordPress output
 * - Register new directory for WordPress template files
 * ------------------------------------------------------------------------------
 */
use Horttcore\Customizer\Customize;
use RalfHortt\Assets\Script;
use RalfHortt\Assets\Style;
use RalfHortt\ImageSizes\ImageSize;
use RalfHortt\TemplateLoader\TemplateLocator;

/**
 * ------------------------------------------------------------------------------
 * Autoloader
 *
 * Load composer autoloader file
 * ------------------------------------------------------------------------------
 */
$autoloader = __DIR__.'/vendor/autoload.php';

if (is_readable($autoloader)) {
    include $autoloader;
}

if (! defined('WPINC')) {
    exit;
}

/**
 * ------------------------------------------------------------------------------
 * Setup theme
 * ------------------------------------------------------------------------------
 */
add_action('after_setup_theme', function () {
    /**
     * ------------------------------------------------------------------------------
     * Setup theme support features
     *
     * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/
     * @see https://developer.wordpress.org/reference/functions/add_theme_support/
     * ------------------------------------------------------------------------------
     */
    load_theme_praxis - unbehend('praxis-unbehend', sprintf('%s/languages', get_stylesheet_directory()));
    add_theme_support('custom-logo');
    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('align-wide');
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support(
        'editor-color-palette',
        [
            [
                'name' => __('Schwarz', 'praxis-unbehend'),
                'slug' => 'black',
                'color' => '#000',
            ],
        ]
    );
    add_theme_support('editor-font-sizes', [
        [
            'name' => __('Klein', 'praxis-unbehend'),
            'size' => 12,
            'slug' => 'small',
        ],
        [
            'name' => __('Normal', 'praxis-unbehend'),
            'size' => 16,
            'slug' => 'normal',
        ],
        [
            'name' => __('Groß', 'praxis-unbehend'),
            'size' => 32,
            'slug' => 'large',
        ],
    ]);
    add_theme_support('editor-styles');
    add_editor_style('dist/css/editor-styles.css');
    remove_theme_support('core-block-patterns');

    /**
     * ------------------------------------------------------------------------------
     * Assets management
     *
     * @see https://github.com/Horttcore/wp-assets
     * ------------------------------------------------------------------------------
     */
    (new Script('theme', get_template_directory_uri().'/dist/js/app.js', ['jquery'], true, true))->register();
    (new Style('sanitize-css', get_template_directory_uri().'/dist/vendor/sanitize-css/sanitize.css'))->register();
    (new Style('theme', get_template_directory_uri().'/dist/css/app.css', ['sanitize-css']))->register();

    /**
     * ------------------------------------------------------------------------------
     * Register menu location
     *
     * @see https://developer.wordpress.org/reference/functions/register_nav_menus/
     * ------------------------------------------------------------------------------
     */
    register_nav_menus(
        [
            'meta' => __('Metamenü', 'praxis-unbehend'),
            'main' => __('Hauptmenü', 'praxis-unbehend'),
            'footer' => __('Footermenü', 'praxis-unbehend'),
        ]
    );

    /**
     * ------------------------------------------------------------------------------
     * Register sidebars
     *
     * @see https://developer.wordpress.org/reference/functions/register_sidebar/
     * ------------------------------------------------------------------------------
     */
    // register_sidebar(
    //     [
    //         'name' => __('Seitenleiste', 'praxis-unbehend'),
    //         'id' => 'sidebar',
    //         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    //         'after_widget'  => '</aside>',
    //         'before_title'  => '<h1 class="widget__title">',
    //         'after_title'   => '</h1>'
    //     ]
    // );

    /**
     * ------------------------------------------------------------------------------
     * Define custom image sizes
     *
     * @see https://github.com/Horttcore/wp-image-sizes
     * ------------------------------------------------------------------------------
     */
    // (new ImageSize('name', __('Label', 'praxis-unbehend'), 50, 50, true))->register();

    /**
     * ------------------------------------------------------------------------------
     * Customizer
     *
     * @see https://github.com/Horttcore/wp-customizer
     * ------------------------------------------------------------------------------
     */
    (new Customize)
        ->panel(__('Einstellungen', 'praxis-unbehend'))
        ->section(__('Kontakt', 'praxis-unbehend'))
        ->text('company', __('Unternehmen', 'praxis-unbehend'))
        ->text('street', __('Straße', 'praxis-unbehend'))
        ->text('street-number', __('Hausnummer', 'praxis-unbehend'))
        ->text('zip', __('PLZ', 'praxis-unbehend'))
        ->text('city', __('Ort', 'praxis-unbehend'))
        ->text('phone', __('Telefon', 'praxis-unbehend'))
        ->text('fax', __('Fax', 'praxis-unbehend'))
        ->text('mobile', __('Mobil', 'praxis-unbehend'))
        ->text('email', __('E-Mail', 'praxis-unbehend'))
        ->url('website', __('Webseite', 'praxis-unbehend'))
        ->url('map', __('Karte', 'praxis-unbehend'))
        ->section(__('Social Media', 'praxis-unbehend'))
        ->url('facebook', __('Facebook', 'praxis-unbehend'))
        ->url('twitter', __('Twitter', 'praxis-unbehend'))
        ->url('instagram', __('Instagram', 'praxis-unbehend'))
        ->section(__('Tracking Codes', 'praxis-unbehend'))
        ->textarea('google-tag-manager', __('Google Tag Manager', 'praxis-unbehend'))
        ->register();

    /**
     * ------------------------------------------------------------------------------
     * Optimizations
     * ------------------------------------------------------------------------------
     */
    remove_action('admin_print_styles', 'print_emoji_styles'); // Emoji
    remove_action('wp_head', 'print_emoji_detection_script', 7); // Emoji
    remove_action('admin_print_scripts', 'print_emoji_detection_script'); // Emoji
    remove_action('wp_print_styles', 'print_emoji_styles'); // Emoji
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email'); // Emoji
    remove_filter('the_content_feed', 'wp_staticize_emoji'); // Emoji
    remove_filter('comment_text_rss', 'wp_staticize_emoji'); // Emoji
    remove_action('wp_head', 'wp_generator'); // Remove WordPress generator meta tag
    remove_action('wp_head', 'rsd_link'); // Remove RSD link meta tag
    remove_action('wp_head', 'wlwmanifest_link'); // Remove WLW manifest link meta tag
    remove_action('wp_head', 'wp_shortlink_wp_head'); // Remove shortlink meta tag
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // Remove adjacent posts link meta tags
    remove_action('wp_head', 'rest_output_link_wp_head'); // Remove REST output link meta tag
    add_filter('the_generator', '__return_null'); // Remove generator output
    add_filter('login_headerurl', 'home_url'); // Replace the login logo link with home url
    add_filter('wp_mail_from', function ($from) {
        if (false !== strpos($from, 'wordpress@')) {
            return $from;
        }

        return get_option('admin_email');
    }); // Replace mail from with current admin email
    // Replace mail from name with site name
    add_filter(
        'wp_mail_from_name',
        function () {
            return get_bloginfo('name');
        }
    );

    /**
     * ------------------------------------------------------------------------------
     * Template loader
     * ------------------------------------------------------------------------------
     */
    (new TemplateLocator('resources/views'))->register();
});

/**
 * ------------------------------------------------------------------------------
 * Put project specific code in functions.custom.php
 * ------------------------------------------------------------------------------
 */
