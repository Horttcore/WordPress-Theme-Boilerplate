<?php

declare(strict_types=1);

/**
 * ------------------------------------------------------------------------------
 * Helper functions
 * ------------------------------------------------------------------------------
 */
function inlineSvgAttachment(int $attachmentId): string
{
    $type = get_post_mime_type($attachmentId);
    if ($type !== 'image/svg+xml') {
        return '';
    }

    return inlineSvg(get_attached_file($attachmentId));
}

function inlineSvg(string $file): string
{
    return file_get_contents($file);
}


/**
 * ------------------------------------------------------------------------------
 * Optimizations
 * ------------------------------------------------------------------------------
 */
remove_theme_support('core-block-patterns');
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
    if (mb_strpos($from, 'wordpress@') !== false) {
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
 * Use custom site logo as login logo
 * ------------------------------------------------------------------------------
 */
add_action('login_enqueue_scripts', function () {
    $custom_logo_id = get_theme_mod('custom_logo');
    if (! $custom_logo_id) {
        return;
    }
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (! $logo) {
        return;
    }
?>
    <style type="text/css">
        .login h1 a {
            background-image: url('<?php echo esc_url($logo[0]); ?>');
            background-size: contain;
            width: 100%;
            height: 80px;
        }
    </style>
<?php
});
