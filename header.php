<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-wrapper">
    <aside class="site-sidebar">
        <nav>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => 'jb_minimal_fallback_menu',
                'depth'          => 1,
                'link_before'    => '',
                'link_after'     => '',
            ));
            ?>
        </nav>
        <form class="sidebar-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" name="s" placeholder="<?php esc_attr_e('Search...', 'jb-minimal'); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
        </form>
        <script>
        (function(){
            var p=location.pathname.replace(/\/+$/,'')||'/';
            document.querySelectorAll('.site-sidebar nav a').forEach(function(a){
                try{
                    var l=new URL(a.href,location.origin).pathname.replace(/\/+$/,'')||'/';
                    if(l===p){
                        a.setAttribute('aria-current','page');
                        var li=a.closest('li');
                        if(li)li.classList.add('current-menu-item');
                    }
                }catch(e){}
            });
        })();
        </script>
        <!-- Prefetch nav pages on hover (Chrome 121+) -->
        <script type="speculationrules">
        {"prefetch":[{"source":"document","where":{"selector_matches":".site-sidebar nav a"},"eagerness":"moderate"}]}
        </script>
        <!-- Fallback: manual prefetch for browsers without Speculation Rules -->
        <script>
        (function(){
            if(HTMLScriptElement.supports&&HTMLScriptElement.supports('speculationrules'))return;
            var seen={};
            document.querySelectorAll('.site-sidebar nav a').forEach(function(a){
                a.addEventListener('mouseover',function(){
                    if(seen[a.href])return;
                    seen[a.href]=true;
                    var l=document.createElement('link');
                    l.rel='prefetch';l.href=a.href;
                    document.head.appendChild(l);
                });
            });
        })();
        </script>
    </aside>

    <main class="site-content">
