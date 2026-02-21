<?php
if (!defined('ABSPATH')) exit;
if (post_password_required()) return;
?>

<div class="comments-area">
    <?php if (have_comments()) : ?>
        <h2><?php
            printf(
                _n('One comment', '%s comments', get_comments_number(), 'jb-minimal'),
                number_format_i18n(get_comments_number())
            );
        ?></h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php comment_form(array(
        'title_reply' => __('Leave a comment', 'jb-minimal'),
    )); ?>
</div>
