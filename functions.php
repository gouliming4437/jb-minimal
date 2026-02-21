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

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => intval($atts['limit']),
        'orderby'        => 'date',
        'order'          => 'DESC',
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
        $year = get_the_date('Y', $post);
        $grouped[$year][] = $post;
    }

    $output = '';
    foreach ($grouped as $year => $year_posts) {
        $output .= '<h2>' . esc_html($year) . '</h2>';
        $output .= '<ul class="post-list">';
        foreach ($year_posts as $post) {
            $output .= '<li class="post-list-item">';
            $output .= '<a href="' . esc_url(get_permalink($post)) . '">';
            $output .= '<span class="post-title">' . esc_html(get_the_title($post)) . '</span>';
            $output .= '<time class="post-date" datetime="' . esc_attr(get_the_date('c', $post)) . '">';
            $output .= esc_html(get_the_date('M j, Y', $post));
            $output .= '</time>';
            $output .= '</a>';
            $output .= '</li>';
        }
        $output .= '</ul>';
    }

    wp_reset_postdata();
    return $output;
}
add_shortcode('jb_archives', 'jb_minimal_archives_shortcode');

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
