<?php get_header(); ?>
<div class="top_mainVisual">
    <div class="swiper tm_swiper-container">
        <ul class="swiper-wrapper">
            <?php if (have_rows('top_slider-01')): ?>
                <?php while (have_rows('top_slider-01')): the_row(); ?>
                    <?php
                    $home_url = esc_url(home_url());
                    $img_pc = get_sub_field('img_pc');
                    $thumb_pc = wp_get_attachment_image_src($img_pc, 'top_main_pc');
                    $alt_pc = isset(get_post($img_pc)->ID) ? get_post_meta(get_post($img_pc)->ID, '_wp_attachment_image_alt', true) : "";
                    $img_sp = get_sub_field('img_sp');
                    $thumb_sp = wp_get_attachment_image_src($img_sp, 'top_main_sp');
                    $alt_sp = isset(get_post($img_sp)->ID) ? get_post_meta(get_post($img_sp)->ID, '_wp_attachment_image_alt', true) : "";
                    $text = get_sub_field('text');
                    ?>
                    <li class="swiper-slide">
                        <p class="tm_background"><img src="<?php echo $home_url . $thumb_sp[0]; ?>" alt="<?php echo $alt_sp; ?>" class="_only-SP"><img src="<?php echo $home_url . $thumb_pc[0]; ?>" alt="<?php echo $alt_pc; ?>" class="_over-TB"></p>
                        <div class="global_inner">
                            <?php if ($text): ?> <p class="tm_title"><span><?php echo $text; ?></span></p><?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <?php if (get_field('top_notice_select')): ?>
        <section id="top_notice-01" class="top_notice-01">
            <div class="content_inner">
                <div class="notice">
                    <div class="head">
                        <h2 class="title">重要なお知らせ</h2>
                    </div>
                    <div class="body">
                        <?php if (have_rows('top_notice-01')): ?>
                            <ul>
                                <?php while (have_rows('top_notice-01')): the_row(); ?>
                                    <?php
                                    $date = get_sub_field('date', false);
                                    $date = new DateTime($date);
                                    $textarea = get_sub_field('textarea');
                                    $none = get_sub_field('none');
                                    ?>
                                    <?php if (!$none): ?>
                                        <li>
                                            <p class="date"><time datetime="<?php echo $date->format('Y-m-d'); ?>"><?php echo $date->format('Y.n.j'); ?></time></p>
                                            <div class="text">
                                                <?php echo $textarea; ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>
<main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
    <section id="top_news-01" class="top_news-01">
        <div class="global_inner">
            <h2 class="top_title-01"><span class="title-main">タイトル</span><span class="title-sub">Sub title</span></h2>
            <?php
            $arg = array(
                'posts_per_page' => 4,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $posts = get_posts($arg);
            if ($posts): ?>
                <?php get_template_part('list', 'news'); ?>
            <?php else: ?>
                <p>お知らせはありません。</p>
            <?php endif; ?>
            <p class="top_button"><a href="<?php echo get_post_type_archive_link('post'); ?>" class="top_button-01"><span>ボタン</span></a></p>
        </div>
    </section>
    <section id="top_news-02" class="top_news-02 _bg_color-gray-01">
        <div class="global_inner">
            <h2 class="top_title-01"><span class="title-main">タイトル</span><span class="title-sub">Sub title</span></h2>
            <?php
            $arg = array(
                'posts_per_page' => 6,
                'has_password' => false,
                'post_type' => 'event',
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $posts = get_posts($arg);
            if ($posts): ?>
                <?php get_template_part('list', 'card'); ?>
            <?php else: ?>
                <p>記事はありません。</p>
            <?php endif; ?>
            <p class="top_button"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="top_button-01"><span>ボタン</span></a></p>
        </div>
    </section>
    <div id="top_banner-01" class="top_banner-01">
        <div class="global_inner">
            <?php if (have_rows('top_banner-01')): ?>
                <ul class="list">
                    <?php while (have_rows('top_banner-01')): the_row(); ?>
                        <?php
                        $img = get_sub_field('img');
                        $thumb = wp_get_attachment_image_src($img, 'top_banner');
                        $title = get_sub_field('title');
                        $alt = isset(get_post($img)->ID) ? get_post_meta(get_post($img)->ID, '_wp_attachment_image_alt', true) : "";
                        $url = get_sub_field('url');
                        $target = get_sub_field('target');
                        ?>
                        <li <?php if (empty($img)): ?>class="_noImage" <?php endif; ?>>
                            <a <?php if (!empty($url)): ?>href="<?php echo esc_url($url); ?>" <?php if ($target): ?>target="_blank" <?php endif; ?><?php else: ?> class="_disabled" tabindex="-1" <?php endif; ?>>
                                <?php if ($img): ?><p class="image"><img src="<?php echo $thumb[0]; ?>" alt="<?php echo $alt; ?>"></p><?php endif; ?>
                                <?php if ($title): ?><p class="title"><?php echo $title; ?></p><?php endif; ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>