<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (!is_category() && !is_tag()) : ?>
    <h1><?php the_archive_title(); ?></h1>
<?php endif; ?>

<?php the_archive_description('<div class="archive-description">', '</div>'); ?>

<?php if (have_posts()) : ?>
    <?php
    $show_dates    = get_theme_mod('jb_show_dates', true);
    $posts_by_year = array();
    while (have_posts()) : the_post();
        $year = get_the_date('Y');
        $posts_by_year[$year][] = array(
            'title'     => get_the_title(),
            'permalink' => get_permalink(),
            'date_c'    => get_the_date('c'),
            'date_fmt'  => get_the_date('M j, Y'),
        );
    endwhile;
    ?>
    <?php foreach ($posts_by_year as $year => $year_posts) : ?>
        <h2 class="archive-year-label"><?php echo esc_html($year); ?> <span class="archive-year-count">&middot; <?php echo count($year_posts); ?></span></h2>
        <ul class="post-list">
            <?php foreach ($year_posts as $p) : ?>
                <li class="post-list-item">
                    <a href="<?php echo esc_url($p['permalink']); ?>">
                        <span class="post-title"><?php echo esc_html($p['title']); ?></span>
                        <?php if ($show_dates) : ?>
                            <time class="post-date" datetime="<?php echo esc_attr($p['date_c']); ?>"><?php echo esc_html($p['date_fmt']); ?></time>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

    <div class="pagination">
        <?php the_posts_navigation(); ?>
    </div>
<?php else : ?>
    <p><?php _e('No posts found.', 'jb-minimal'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
