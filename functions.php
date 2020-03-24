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
use \Horttcore\Assets\Script;
use \Horttcore\Assets\Style;
use \Horttcore\Customizer\Customize;
use \RalfHortt\ContentWidth\ContentWidth;
use \RalfHortt\ImageSizes\ImageSize;
use \RalfHortt\TemplateLoader\TemplateLocator;

/**
 * ------------------------------------------------------------------------------
 * Autoloader
 *
 * Load composer autoloader file
 * ------------------------------------------------------------------------------
 */
$autoloader = __DIR__ . '/vendor/autoload.php';

if (is_readable($autoloader)) :
    include $autoloader;
endif;

if (!defined('WPINC')) :
    die;
endif;

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
                'name' => __('Schwarz', 'TEXTDOMAIN'),
                'slug' => 'black',
                'color' => '#000',
            ],
        ]
    );
    add_theme_support('editor-font-sizes', [
        [
            'name' => __('Klein', 'TEXTDOMAIN'),
            'size' => 12,
            'slug' => 'small'
        ],
        [
            'name' => __('Normal', 'TEXTDOMAIN'),
            'size' => 16,
            'slug' => 'normal'
        ],
        [
            'name' => __('Groß', 'TEXTDOMAIN'),
            'size' => 32,
            'slug' => 'large'
        ],
    ]);
    add_theme_support('editor-styles');
    add_editor_style('dist/css/editor-styles.css');


    /**
     * ------------------------------------------------------------------------------
     * Set content width
     *
     * @see https://codex.wordpress.org/Content_Width
     * ------------------------------------------------------------------------------
     */
    (new ContentWidth(980))->register();


    /**
     * ------------------------------------------------------------------------------
     * Assets management
     *
     * @see https://github.com/Horttcore/wp-assets
     * ------------------------------------------------------------------------------
     */
    (new Script('theme', get_template_directory_uri() . '/dist/js/app.js', ['jquery'], true, true))->register();
    (new Style('sanitize-css', get_template_directory_uri() . '/dist/vendor/sanitize-css/sanitize.css'))->register();
    (new Style('theme', get_template_directory_uri() . '/dist/css/app.css', ['sanitize-css']))->register();


    /**
     * ------------------------------------------------------------------------------
     * Register menu location
     *
     * @see https://developer.wordpress.org/reference/functions/register_nav_menus/
     * ------------------------------------------------------------------------------
     */
    register_nav_menus(
        [
            'meta' => __('Metamenü', 'TEXTDOMAIN'),
            'main' => __('Hauptmenü', 'TEXTDOMAIN'),
            'footer' => __('Footermenü', 'TEXTDOMAIN'),
        ]
    );


    /**
     * ------------------------------------------------------------------------------
     * Register sidebars
     *
     * @see https://developer.wordpress.org/reference/functions/register_sidebar/
     * ------------------------------------------------------------------------------
     */
    register_sidebar(
        [
            'name' => __('Seitenleiste', 'TEXTDOMAIN'),
            'id' => 'sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h1 class="widget__title">',
            'after_title'   => '</h1>'
        ]
    );


    /**
     * ------------------------------------------------------------------------------
     * Define custom image sizes
     *
     * @see https://developer.wordpress.org/reference/functions/register_sidebar/
     * ------------------------------------------------------------------------------
     */
    (new ImageSize('name', __('Label', 'TEXTDOMAIN'), 50, 50, true))->register();


    /**
     * ------------------------------------------------------------------------------
     * Customizer
     *
     * @see https://github.com/Horttcore/wp-customizer
     * ------------------------------------------------------------------------------
     */
    (new Customize)
        ->panel(__('Einstellungen', 'TEXTDOMAIN'))
        ->section(__('Kontakt', 'TEXTDOMAIN'))
        ->text('company', __('Unternehmen', 'TEXTDOMAIN'))
        ->text('street', __('Straße', 'TEXTDOMAIN'))
        ->text('street-number', __('Hausnummer', 'TEXTDOMAIN'))
        ->text('zip', __('PLZ', 'TEXTDOMAIN'))
        ->text('city', __('Ort', 'TEXTDOMAIN'))
        ->text('phone', __('Telefon', 'TEXTDOMAIN'))
        ->text('fax', __('Fax', 'TEXTDOMAIN'))
        ->text('mobile', __('Mobil', 'TEXTDOMAIN'))
        ->text('email', __('E-Mail', 'TEXTDOMAIN'))
        ->url('website', __('Webseite', 'TEXTDOMAIN'))
        ->url('map', __('Karte', 'TEXTDOMAIN'))
        ->section(__('Social Media', 'TEXTDOMAIN'))
        ->url('facebook', __('Facebook', 'TEXTDOMAIN'))
        ->url('twitter', __('Twitter', 'TEXTDOMAIN'))
        ->url('instagram', __('Instagram', 'TEXTDOMAIN'))
        ->section(__('Tracking Codes', 'TEXTDOMAIN'))
        ->textarea('google-tag-manager', __('Google Tag Manager', 'TEXTDOMAIN'))
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
     */ (new TemplateLocator('resources/views'))->register();
});

/**
 * ------------------------------------------------------------------------------
 * Put project specific code in functions.custom.php
 * ------------------------------------------------------------------------------
 */
