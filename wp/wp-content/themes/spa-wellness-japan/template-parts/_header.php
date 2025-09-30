<header id="global_header" class="global_header" itemscope itemtype="https://schema.org/WPHeader">
    <div class="inner">
        <?php if (is_front_page()) : ?>
            <h1 class="gh_logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/common/logo.svg" alt="<?php bloginfo('name'); ?>"></a></h1>
        <?php else: ?>
            <p class="gh_logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/common/logo.svg" alt="<?php bloginfo('name'); ?>"></a></p>
        <?php endif; ?>
        <button type="button" class="gh_menu" id="gh_menu"><span class="icon"></span><i>menu</i></button>
    </div>
</header>
<nav id="global_navigation" class="global_navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
    <ul class="gn_links-01 module_menu-01">
        <?php if (have_rows('common-menu-01', 'option')): ?>
            <?php while (have_rows('common-menu-01', 'option')): the_row(); ?>
                <?php
                $title01 = get_sub_field('title-01');
                $url01 = get_sub_field('url-01');
                $target01 = get_sub_field('target-01');
                $header = get_sub_field('hide-header');
                $select01 = get_sub_field('select-01');
                ?>
                <?php if ($header != 'none'): ?>
                    <?php if ($select01): ?>
                        <li class="_hasChild <?php if ($header == "only-SP"): ?>_only-SP<?php elseif ($header == "over-TB"): ?>_over-TB<?php endif; ?>">
                            <button class="gnl_button mm_button" type="button"><span>開閉</span></button>
                            <a class="gnl_title mm_title" href="<?php echo $url01; ?>" <?php if ($target01): ?>target="_blank" <?php endif; ?>><?php echo $title01; ?></a>
                            <div class="gnl_wrapper mm_wrapper-01">
                                <div class="gnl_inner mm_inner-01">
                                    <div class="gnl_title"><a href="<?php echo $url01; ?>" <?php if ($target01): ?>target="_blank" <?php endif; ?>><span><?php echo $title01; ?></span></a></div>
                                    <ul>
                                        <?php if (have_rows('hierarchy-02', 'option')): ?>
                                            <?php while (have_rows('hierarchy-02', 'option')): the_row(); ?>
                                                <?php
                                                $title02 = get_sub_field('title-02');
                                                $url02 = get_sub_field('url-02');
                                                $target02 = get_sub_field('target-02');
                                                $select02 = get_sub_field('select-02'); //4階層目なしの場合削除し、if( $select02 )内の4階層目なし<li>のみwhile内に残す
                                                ?>
                                                <?php if ($select02): ?>
                                                    <li>
                                                        <button class="gnl_button mm_button-01" type="button"><span>開閉</span></button>
                                                        <a class="gnl_title mm_title-01" href="<?php echo $url02; ?>" <?php if ($target02): ?>target="_blank" <?php endif; ?>><?php echo $title02; ?></a>
                                                        <div class="gnl_wrapper mm_wrapper-02">
                                                            <div class="gnl_inner mm_inner-02">
                                                                <ul>
                                                                    <?php if (have_rows('hierarchy-03', 'option')): //4階層目出力開始 
                                                                    ?>
                                                                        <?php while (have_rows('hierarchy-03', 'option')): the_row(); ?>
                                                                            <?php
                                                                            $title03 = get_sub_field('title-03');
                                                                            $url03 = get_sub_field('url-03');
                                                                            $target03 = get_sub_field('target-03');
                                                                            ?>
                                                                            <li><a class="gnl_title mm_title-02" href="<?php echo $url03; ?>" <?php if ($target03): ?>target="_blank" <?php endif; ?>><?php echo $title03; ?></a></li>
                                                                        <?php endwhile; ?>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php else: ?>
                                                    <li><a class="gnl_title mm_title-01" href="<?php echo $url02; ?>" <?php if ($target02): ?>target="_blank" <?php endif; ?>><?php echo $title02; ?></a></li>
                                                <?php endif; ?>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li <?php if ($header == "only-SP"): ?>class="_only-SP" <?php elseif ($header == "over-TB"): ?>class="_over-TB" <?php endif; ?>>
                            <a class="gnl_title mm_title" href="<?php echo $url01; ?>" <?php if ($target01): ?>target="_blank" <?php endif; ?>><?php echo $title01; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
    <ul class="gn_links-02 module_menu-02">
        <?php if (have_rows('common-submenu-01', 'option')): ?>
            <?php while (have_rows('common-submenu-01', 'option')): the_row(); ?>
                <?php
                $title = get_sub_field('title');
                $url = get_sub_field('url');
                $target = get_sub_field('target');
                $header = get_sub_field('hide-header');
                $select = get_sub_field('select');
                ?>
                <?php if ($header != 'none'): ?>
                    <li class="<?php if ($header == "only-SP"): ?>_only-SP<?php elseif ($header == "over-TB"): ?>_over-TB<?php endif; ?>">
                        <a href="<?php echo $url; ?>" <?php if ($target): ?>target="_blank" <?php endif; ?>><span><?php echo $title; ?></span></a>
                    </li>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php if (have_rows('common-submenu-02', 'option')): ?>
            <?php while (have_rows('common-submenu-02', 'option')): the_row(); ?>
                <?php
                $title = get_sub_field('title');
                $url = get_sub_field('url');
                $target = get_sub_field('target');
                $header = get_sub_field('hide-header');
                $select = get_sub_field('select');
                ?>
                <?php if ($header != 'none'): ?>
                    <li><a href="<?php echo $url; ?>" <?php if ($target): ?>target="_blank" <?php endif; ?>><span><?php echo $title; ?></span></a></li>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
    <div class="inner">
        <div class="gn_search module_search-01">
            <form class="gns_form ms_from" role="search" method="get" action="/">
                <input class="ms_input" type="search" value="" name="s" id="s" placeholder="キーワード">
                <button type="submit" class="ms_button"><span>検索</span></button>
            </form>
        </div>
        <button type="button" class="gn_close" id="gn_close"><span>閉じる</span></button>
    </div>
</nav>
<div class="overlay" id="overlay"></div>