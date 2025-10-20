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
  <section id="top_about-01" class="top_about-01">
    <div class="global_inner">
      <div class="titleBox">
        <h2 class="top_title-01 _small _left">
          <span class="title-main">About</span>
          <span class="title-sub">日本スパ・ウエルネス協会について</span>
        </h2>
      </div>
      <div class="contentsBox">
        <div class="top_text-01">日本スパ・ウエルネス協会は、セラピストの社会的地位の向上と確立、我が国における健全なエステティック普及や発展を目的として幅広い活動を展開している団体です。</div>
        <div class="wp-block-buttons">
          <div class="wp-block-button"><a href="/about/" class="wp-block-button__link"><span>日本スパ・ウエルネス協会とは</span></a></div>
        </div>
      </div>
    </div>
  </section>
  <section id="top_publications-01" class="top_publications-01">
    <div class="global_inner">
      <h2 class="top_title-01 _white">
        <span class="title-main">Publications</span>
        <span class="title-sub">教材・例題集</span>
        <span class="icon">
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
        </span>
      </h2>
      <div class="top_text-01">資格取得を目指す方のために、公式テキストと例題集をご用意しています。<br>お申込みは下記フォームより受け付けています。</div>
      <div class="module_publications-01">
        <div class="wrap">
          <div class="inner">
            <div class="imageBox">
              <div class="image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/common/img-book.webp" alt="book">
              </div>
            </div>
            <div class="contentsBox">
              <div class="wp-block-buttons">
                <div class="wp-block-button"><a href="/parts/" class="wp-block-button__link"><span>教材の一覧はこちら</span></a></div>
                <div class="wp-block-button"><a href="/parts/" class="wp-block-button__link"><span>協会公式テキスト・教材を申し込む</span></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="module_publications-02">
        <div class="wrap">
          <div class="inner">
            <div class="imageBox">
              <div class="image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/common/img-ipsn.webp" alt="ipsn">
              </div>
            </div>
            <div class="contentsBox">
              <div class="title">IPSN国際資格</div>
              <div class="text">ＩＰＳＮ（国際職業人標準機構）は、各国の技術・教育レベルの基準を確認し、各国の資格の相互認証を目指す団体です。海外でも通用するこのライセンスは、就職・転職・スキルアップの強力な武器となり、グローバルなキャリア形成を目指す方に最適です。</div>
              <div class="wp-block-buttons">
                <div class="wp-block-button button-type02"><a href="/parts/" class="wp-block-button__link" target="_blank"><span>日本語版：公式ホームページはこちら</span></a></div>
                <div class="wp-block-button button-type02"><a href="/parts/" class="wp-block-button__link" target="_blank"><span>英語版：公式ホームページはこちら</span></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="top_link-01" class="top_link-01">
    <div class="global_inner">
      <h2 class="top_title-01">
        <span class="title-main">Link</span>
        <span class="title-sub">関連リンク</span>
        <span class="icon">
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
        </span>
      </h2>
      <div class="module_linkBox-01">
        <div class="wrap">
          <div class="inner">
            <div class="titleBox">
              <h3 class="title"><span>美容・健康関連業界に特化した求人情報サイト<br>「Beauty & Wellness Partners」</span></h3>
            </div>
            <div class="imageBox">
              <div class="image">
                <img src="/wp/wp-content/uploads/2025/10/noimage.png" alt="美容・健康関連業界に特化した求人情報サイト「Beauty & Wellness Partners」">
              </div>
            </div>
            <div class="contentsBox">
              <div class="text">当協会登録企業様である、株式会社ミス・パリが運営する「Beauty & Wellness Partners」（以下 BWP）では、理美容国家資格や専門学校で学んで取得した資格を活かせる企業様とのベストマッチングをいたします。</div>
              <div class="module_button --small">
                <a href=".pdf" class="_blue" target="_blank"><span>ご案内パンフレットはこちら</span></a>
                <a href="/parts/" class="_blue" target="_blank"><span>利用登録はBWPのホームページから</span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="wrap">
          <div class="inner">
            <div class="titleBox">
              <h3 class="title2">
                <span class="icon _left">
                  <?php get_template_part( '/images/ico/ico', 'star' ); ?>
                </span>  
                <span>関連教育機関</span>
                <span class="icon _right">
                  <?php get_template_part( '/images/ico/ico', 'star' ); ?>
                </span>
              </h3>
            </div>
            <div class="bannerBox">
              <a href="/parts/">
                <img src="/wp/wp-content/uploads/2025/10/noimage.png" alt="美容・健康関連業界に特化した求人情報サイト「Beauty & Wellness Partners」">
              </a>
              <a href="/parts/">
                <img src="/wp/wp-content/uploads/2025/10/noimage.png" alt="美容・健康関連業界に特化した求人情報サイト「Beauty & Wellness Partners」">
              </a>
              <a href="/parts/">
                <img src="/wp/wp-content/uploads/2025/10/noimage.png" alt="美容・健康関連業界に特化した求人情報サイト「Beauty & Wellness Partners」">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>