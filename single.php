<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<article <?php post_class(); ?>>
    <header>
        <h1><?php the_title(); ?></h1>
        <?php if (get_theme_mod('jb_show_dates', true)) : ?>
            <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                <?php echo get_the_date('M j, Y'); ?>
            </time>
        <?php endif; ?>
    </header>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    <script>
    (function(){
        var sel = '.entry-content .wp-block-footnotes, .entry-content .footnotes, .entry-content [role="doc-endnotes"]';
        var fn = document.querySelector(sel);
        if (fn) {
            var h = document.createElement('h2');
            h.textContent = 'References';
            fn.parentNode.insertBefore(h, fn);
            var prev = h.previousElementSibling;
            if (!prev || prev.tagName !== 'HR') {
                var hr = document.createElement('hr');
                h.parentNode.insertBefore(hr, h);
            }
        }
    })();
    </script>

    <?php
    if (get_theme_mod('jb_show_comments', true) && (comments_open() || get_comments_number())) {
        comments_template();
    }
    ?>
</article>

<?php get_footer(); ?>
