<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<div class="not-found">
    <h1><?php _e('Page Not Found', 'jb-minimal'); ?></h1>
    <p><?php _e('The page you are looking for does not exist.', 'jb-minimal'); ?></p>
    <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('&larr; Back to home', 'jb-minimal'); ?></a></p>
</div>

<?php get_footer(); ?>
