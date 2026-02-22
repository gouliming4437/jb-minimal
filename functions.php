<?php
/**
 * JB Minimal Theme Functions
 */

// === Theme Setup ===
function jb_minimal_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'
    ));
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
    add_theme_support('custom-logo');

    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'jb-minimal'),
    ));
}
add_action('after_setup_theme', 'jb_minimal_setup');

// === Enqueue Styles ===
function jb_minimal_scripts() {
    $css_file = get_stylesheet_directory() . '/style.css';
    $version  = file_exists($css_file) ? filemtime($css_file) : wp_get_theme()->get('Version');
    wp_enqueue_style('jb-minimal-style', get_stylesheet_uri(), array(), $version);
}
add_action('wp_enqueue_scripts', 'jb_minimal_scripts');

// === Customizer ===
function jb_minimal_customize_register($wp_customize) {

    // --- Colors Section (extend default) ---
    $wp_customize->add_setting('jb_text_color', array(
        'default' => '#262626',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jb_text_color', array(
        'label' => __('Text Color', 'jb-minimal'),
        'section' => 'colors',
    )));

    $wp_customize->add_setting('jb_heading_color', array(
        'default' => '#171717',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jb_heading_color', array(
        'label' => __('Heading Color', 'jb-minimal'),
        'section' => 'colors',
    )));

    $wp_customize->add_setting('jb_border_color', array(
        'default' => '#e5e5e5',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jb_border_color', array(
        'label' => __('Border / Accent Color', 'jb-minimal'),
        'section' => 'colors',
    )));

    // --- Social Links Section ---
    $wp_customize->add_section('jb_social', array(
        'title'       => __('Social Links', 'jb-minimal'),
        'description' => __('Add up to 5 links. Leave a label or URL blank to hide that slot.', 'jb-minimal'),
        'priority'    => 120,
    ));

    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("jb_social_{$i}_label", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("jb_social_{$i}_label", array(
            'label'   => sprintf(__('Link %d Label', 'jb-minimal'), $i),
            'section' => 'jb_social',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("jb_social_{$i}_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("jb_social_{$i}_url", array(
            'label'   => sprintf(__('Link %d URL', 'jb-minimal'), $i),
            'section' => 'jb_social',
            'type'    => 'url',
        ));
    }

    // --- Homepage Section ---
    $wp_customize->add_section('jb_homepage', array(
        'title' => __('Homepage Settings', 'jb-minimal'),
        'priority' => 130,
    ));

    $wp_customize->add_setting('jb_bio_text', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('jb_bio_text', array(
        'label'   => __('Bio Text', 'jb-minimal'),
        'section' => 'jb_homepage',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('jb_show_social_home', array(
        'default' => true,
        'sanitize_callback' => 'jb_minimal_sanitize_checkbox',
    ));
    $wp_customize->add_control('jb_show_social_home', array(
        'label'   => __('Show Social Links on Homepage', 'jb-minimal'),
        'section' => 'jb_homepage',
        'type'    => 'checkbox',
    ));

    // --- Blog Section ---
    $wp_customize->add_section('jb_blog', array(
        'title' => __('Blog Settings', 'jb-minimal'),
        'priority' => 135,
    ));

    $wp_customize->add_setting('jb_show_dates', array(
        'default' => true,
        'sanitize_callback' => 'jb_minimal_sanitize_checkbox',
    ));
    $wp_customize->add_control('jb_show_dates', array(
        'label'   => __('Show Post Dates', 'jb-minimal'),
        'section' => 'jb_blog',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('jb_show_comments', array(
        'default' => true,
        'sanitize_callback' => 'jb_minimal_sanitize_checkbox',
    ));
    $wp_customize->add_control('jb_show_comments', array(
        'label'   => __('Show Comments on Posts', 'jb-minimal'),
        'section' => 'jb_blog',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'jb_minimal_customize_register');

// === Sanitize Checkbox ===
function jb_minimal_sanitize_checkbox($input) {
    return (bool) $input;
}

// === Output Customizer CSS Variables ===
function jb_minimal_customizer_css() {
    $text    = get_theme_mod('jb_text_color', '#262626');
    $heading = get_theme_mod('jb_heading_color', '#171717');
    $border  = get_theme_mod('jb_border_color', '#e5e5e5');

    // Skip output entirely when nothing has been customised.
    if ( $text === '#262626' && $heading === '#171717' && $border === '#e5e5e5' ) {
        return;
    }
    ?>
    <style>
        :root {
            --jb-text: <?php echo esc_attr($text); ?>;
            --jb-heading: <?php echo esc_attr($heading); ?>;
            --jb-border: <?php echo esc_attr($border); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'jb_minimal_customizer_css');

// === Social Links Helper ===
function jb_minimal_social_links() {
    $links = array();

    for ($i = 1; $i <= 5; $i++) {
        $label = trim(get_theme_mod("jb_social_{$i}_label", ''));
        $url   = trim(get_theme_mod("jb_social_{$i}_url", ''));
        if ($label && $url) {
            $links[] = '<a href="' . esc_url($url) . '" rel="noopener noreferrer" target="_blank">' . esc_html($label) . '</a>';
        }
    }

    if (!empty($links)) {
        echo '<div class="social-links">' . implode('', $links) . '</div>';
    }
}

// === Active Nav Class Helper ===
function jb_minimal_nav_class($classes, $item) {
    if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
        $classes[] = 'current';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'jb_minimal_nav_class', 10, 2);

// === Archive Shortcode ===
// Usage: [jb_archives]                        — all posts grouped by year
//        [jb_archives limit="50"]             — limit total posts
//        [jb_archives category="news"]        — filter by category slug
//        [jb_archives year="2026"]            — single year only
function jb_minimal_archives_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit'    => -1,
        'category' => '',
        'year'     => '',
    ), $atts, 'jb_archives');

    // Serve from cache when available.
    // The version prefix means invalidation only requires bumping the version —
    // no need to know or delete individual cache keys. This works correctly
    // whether transients are stored in wp_options or a persistent cache (Memcached/Redis).
    $version   = (int) get_option('jb_arc_cache_ver', 0);
    $cache_key = 'jb_arc_' . $version . '_' . md5(serialize($atts));
    $cached    = get_transient($cache_key);
    if ( false !== $cached ) {
        return $cached;
    }

    $limit = intval($atts['limit']);
    $args  = array(
        'post_type'              => 'post',
        'post_status'            => 'publish',
        'posts_per_page'         => ($limit < 0) ? 500 : $limit,
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,  // skip SQL_CALC_FOUND_ROWS — we don't paginate
        'update_post_term_cache' => false, // skip priming term cache — not used in output
        'update_post_meta_cache' => false, // skip priming meta cache — not used in output
    );

    if (!empty($atts['category'])) {
        $args['category_name'] = sanitize_text_field($atts['category']);
    }

    if (!empty($atts['year'])) {
        $args['year'] = intval($atts['year']);
    }

    $posts = get_posts($args);

    if (empty($posts)) {
        return '<p>' . esc_html__('No posts found.', 'jb-minimal') . '</p>';
    }

    $grouped = array();
    foreach ($posts as $post) {
        $ts   = strtotime($post->post_date);
        $year = date('Y', $ts);
        $grouped[$year][] = array('post' => $post, 'ts' => $ts);
    }

    $output = '';
    foreach ($grouped as $year => $year_posts) {
        $output .= '<h2>' . esc_html($year) . '</h2>';
        $output .= '<ul class="post-list">';
        foreach ($year_posts as $entry) {
            $post = $entry['post'];
            $ts   = $entry['ts'];
            $output .= '<li class="post-list-item">';
            $output .= '<a href="' . esc_url(get_permalink($post)) . '">';
            $output .= '<span class="post-title">' . esc_html(get_the_title($post)) . '</span>';
            $output .= '<time class="post-date" datetime="' . esc_attr(date('c', $ts)) . '">';
            $output .= esc_html(date('M j, Y', $ts));
            $output .= '</time>';
            $output .= '</a>';
            $output .= '</li>';
        }
        $output .= '</ul>';
    }

    set_transient($cache_key, $output, DAY_IN_SECONDS);
    return $output;
}
add_shortcode('jb_archives', 'jb_minimal_archives_shortcode');

// === Archive Cache Invalidation ===
// Bumping the version makes every existing jb_arc_* key unreachable without
// needing to know or enumerate them — safe for both Memcached/Redis (where
// transients live in the object cache, not wp_options) and the default
// options-table storage.
function jb_minimal_flush_archive_cache() {
    update_option('jb_arc_cache_ver', time(), true); // autoloaded = free to read

    // On sites without a persistent cache plugin, old transient rows accumulate
    // in wp_options. Clean them up. With a persistent cache active, transients
    // are in Memcached/Redis (not the options table), so we skip the query.
    if ( ! wp_using_ext_object_cache() ) {
        global $wpdb;
        $wpdb->query(
            "DELETE FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_jb_arc_%'
                OR option_name LIKE '_transient_timeout_jb_arc_%'"
        );
    }
}
add_action('save_post_post', 'jb_minimal_flush_archive_cache');
add_action('delete_post',    'jb_minimal_flush_archive_cache');
add_action('trash_post',     'jb_minimal_flush_archive_cache');
add_action('untrash_post',   'jb_minimal_flush_archive_cache');

// === Remove Unused WordPress Overhead ===
// Emoji polyfill: ~10 KB of JS + a DNS prefetch to s.w.org on every page.
// Removed from the front-end only; the block editor keeps its emoji picker.
function jb_minimal_disable_emoji() {
    remove_action('wp_head',         'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail',          'wp_staticize_emoji_for_email');
    add_filter('wp_resource_hints',  'jb_minimal_remove_emoji_dns_prefetch', 10, 2);
}
add_action('init', 'jb_minimal_disable_emoji');

function jb_minimal_remove_emoji_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $urls = array_filter($urls, function($url) {
            return strpos($url, 'https://s.w.org') === false;
        });
    }
    return $urls;
}

// wp-embed: ~3 KB of JS for embedding your posts on other sites — not needed here.
add_action('wp_footer', function() { wp_dequeue_script('wp-embed'); });

// === Clean Archive Titles ===
function jb_minimal_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    }
    return $title;
}
add_filter('get_the_archive_title', 'jb_minimal_archive_title');

// === Fallback Menu ===
function jb_minimal_fallback_menu() {
    $is_home  = is_front_page() || is_home();
    $li_class = $is_home ? 'page_item current_page_item' : 'page_item';
    $aria     = $is_home ? ' aria-current="page"' : '';
    echo '<li class="' . esc_attr($li_class) . '"><a href="' . esc_url(home_url('/')) . '"' . $aria . '>' . esc_html__('Home', 'jb-minimal') . '</a></li>';
    wp_list_pages(array(
        'title_li' => '',
        'depth'    => 1,
    ));
}
