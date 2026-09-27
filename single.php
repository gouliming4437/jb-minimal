<?php if (!defined('ABSPATH')) exit; ?>
<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>>
    <header>
        <h1><?php the_title(); ?></h1>
        <?php if (get_theme_mod('jb_show_dates', true)) : ?>
            <time class="post-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo get_the_date('M j, Y'); ?>
            </time>
        <?php endif; ?>
    </header>

    <?php
    // Same filters as the_content(), then ids + TOC built server-side.
    $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
    list($toc, $content) = jb_minimal_build_toc($content);
    echo $toc;
    ?>
    <div class="entry-content">
        <?php echo $content; ?>
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
<?php endwhile; ?>

<?php get_footer(); ?>
