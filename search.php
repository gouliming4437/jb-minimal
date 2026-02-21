<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<div class="search-header">
    <h1><?php printf(__('Search: "%s"', 'jb-minimal'), esc_html(get_search_query())); ?></h1>
    <?php get_search_form(); ?>
</div>

<?php if (have_posts()) : ?>
    <ul class="post-list">
        <?php while (have_posts()) : the_post(); ?>
            <li class="post-list-item">
                <a href="<?php the_permalink(); ?>">
                    <span class="post-title"><?php the_title(); ?></span>
                    <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date('M j, Y'); ?>
                    </time>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    <div class="pagination">
        <?php the_posts_navigation(); ?>
    </div>
<?php else : ?>
    <p><?php _e('No results found. Try a different search.', 'jb-minimal'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
