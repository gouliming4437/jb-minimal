<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php if (get_option('show_on_front') === 'page' && get_option('page_on_front')) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
    <hr>
    <?php if (get_theme_mod('jb_show_social_home', true)) : ?>
        <?php jb_minimal_social_links(); ?>
    <?php endif; ?>
<?php else : ?>
    <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
    <?php
    $bio = get_theme_mod('jb_bio_text', '');
    if ($bio) :
    ?>
        <div class="bio-text">
            <?php echo wp_kses_post($bio); ?>
        </div>
    <?php endif; ?>
    <hr>
    <?php if (get_theme_mod('jb_show_social_home', true)) : ?>
        <?php jb_minimal_social_links(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php get_footer(); ?>
