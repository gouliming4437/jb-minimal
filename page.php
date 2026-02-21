<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<article <?php post_class(); ?>>
    <h1><?php the_title(); ?></h1>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>

<?php get_footer(); ?>
