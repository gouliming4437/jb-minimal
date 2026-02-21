<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (is_home() && !is_front_page()) : ?>
    <h1><?php single_post_title(); ?></h1>
<?php endif; ?>

<?php if (have_posts()) : ?>
    <ul class="post-list">
        <?php while (have_posts()) : the_post(); ?>
            <li class="post-list-item">
                <a href="<?php the_permalink(); ?>">
                    <span class="post-title"><?php the_title(); ?></span>
                    <?php if (get_theme_mod('jb_show_dates', true)) : ?>
                        <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date('M j, Y'); ?>
                        </time>
                    <?php endif; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    <div class="pagination">
        <?php
        the_posts_navigation(array(
            'prev_text' => __('&larr; Older', 'jb-minimal'),
            'next_text' => __('Newer &rarr;', 'jb-minimal'),
        ));
        ?>
    </div>

<?php else : ?>
    <p><?php _e('No posts found.', 'jb-minimal'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
