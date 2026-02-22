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
        var content = document.querySelector('.entry-content');
        if (!content) return;

        var headings = Array.prototype.slice.call(content.querySelectorAll('h2, h3'));
        if (headings.length < 2) return;

        // Ensure every heading has an id for anchor links
        var used = {};
        headings.forEach(function(h) {
            if (!h.id) {
                var base = h.textContent.trim()
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-');
                var id = base, n = 1;
                while (used[id]) { id = base + '-' + (++n); }
                h.id = id;
            }
            used[h.id] = true;
        });

        var nav  = document.createElement('nav');
        nav.className = 'toc';
        var root = document.createElement('ol');
        var lastH2 = null, subOl = null;

        headings.forEach(function(h) {
            var li = document.createElement('li');
            var a  = document.createElement('a');
            a.href = '#' + h.id;
            a.textContent = h.textContent.trim();
            li.appendChild(a);

            if (h.tagName === 'H2') {
                lastH2 = li; subOl = null;
                root.appendChild(li);
            } else {
                if (!subOl) {
                    subOl = document.createElement('ol');
                    (lastH2 || root).appendChild(subOl);
                }
                subOl.appendChild(li);
            }
        });

        nav.appendChild(root);
        content.parentNode.insertBefore(nav, content);
    })();
    </script>
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
