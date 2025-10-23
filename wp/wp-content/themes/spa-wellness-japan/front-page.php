<?php get_header(); ?>
<div class="top_mainVisual">
  <div class="viasul">
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
            ?>
            <li class="swiper-slide">
              <div class="tm_background">
                <img src="<?php echo $home_url . $thumb_sp[0]; ?>" alt="<?php echo $alt_sp; ?>" class="_only-SP">
                <img src="<?php echo $home_url . $thumb_pc[0]; ?>" alt="<?php echo $alt_pc; ?>" class="_over-TB">
              </div>
            </li>
          <?php endwhile; ?>
        <?php endif; ?>
      </ul>
      <div class="swiper-pagination"></div>
    </div>
    <div class="catchcopy">
      <div class="main"><img src="<?php echo get_template_directory_uri(); ?>/images/common/catchcopy.webp" alt="SPA Wellness"></div>
      <div class="sub">日本スパ・ウエルネス協会は<br><span>セラピストの地位向上</span>と<br class="_only-SP"><span>業界の健全な発展</span>を目指し活動しています</div>
    </div>
  </div>
  <div class="contents">
    <div class="news">
      <div class="module_tab-02">
        <?php
        $postType = 'post';
        $postsPerPage = 2;
        $listType = 'news';
        $postTopId = get_option('page_for_posts');
        $postTypeTopSlug = get_post_field('post_name', $postTopId);
        ?>
        <div class="module_tab-head">
          <h2 class="title">
            <span class="main">News</span>
            <span class="sub">協会からのお知らせ</span>
          </h2>
          <div class="module_select-02">
            <div class="wrap">
              <select name="area">
                <option disabled selected value>カテゴリーを選択</option>
                <option value="tab01-all">すべて</option>
                <?php
                // 親カテゴリーのものだけを一覧で取得
                $args = array(
                  'post_type' => $postType, // 投稿タイプの指定
                  'orderby' => 'id',
                  'hide_empty' => true, // 投稿がないカテゴリを出すかどうか
                  'parent' => 0,
                );
                $categories = get_categories( $args );
                ?>
                <?php foreach( $categories as $category ) : ?>
                  <?php
                  $slug = $category->slug;
                  $name = $category->name;
                  ?>
                  <option value="tab01-<?php echo $slug; ?>">
                    <?php echo $name ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="module_tab-body" id="tab01-all" style="display:block">
          <?php
          $arg = array(
            'posts_per_page' => $postsPerPage,
            'has_password' => false,
            'post_type' => $postType,
            'orderby' => 'date',
            'order' => 'DESC'
          );
          $posts = get_posts($arg);

          get_template_part( 'list',$listType);
          ?>
        </div><!-- /module_tab-body -->
        <?php
        // 親カテゴリーのものだけを一覧で取得
        $args = array(
          'post_type' => $postType, // 投稿タイプの指定
          'orderby' => 'id',
          'hide_empty' => true, // 投稿がないカテゴリを出すかどうか
          'parent' => 0,
        );
        $categories = get_categories( $args );
        ?>
        <?php foreach( $categories as $category ) : ?>
          <?php
          $slug = $category->slug;
          $name = $category->name;
          ?>
          <div class="module_tab-body" id="tab01-<?php echo $slug; ?>" style="display:none">
            <?php
            $arg = array(
              'posts_per_page' => $postsPerPage,
              'has_password' => false,
              'post_type' => $postType,
              'orderby' => 'date',
              'order' => 'DESC',
              'category_name' => $slug,
            );
            $posts = get_posts($arg);

            get_template_part( 'list',$listType);
            ?>
          </div>
        <?php endforeach; ?>
        <a href="/news/" class="tab-button">
          <span>お知らせ一覧を見る</span>
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="4" viewBox="0 0 10 4" fill="none">
              <path d="M0.5 3.5H9.5L7 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
      </div><!-- /module_tab-01 -->
    </div>
    <div class="button">
      <h3 class="title">
        <span class="icon _left">
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
        </span> 
        <span class="wrap">
          <span class="main">For Members</span>
          <span class="sub">会員の方へ</span>
        </span> 
        <span class="icon _right">
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
        </span>
      </h3>
      <div class="buttonBox">
        <div class="wp-block-buttons">
          <div class="wp-block-button"><a href="/parts/" class="wp-block-button__link"><span>資格・検定試験一覧を見る</span></a></div>
          <div class="wp-block-button"><a href="/parts/" class="wp-block-button__link"><span>協会公式テキスト・<br class="_over-TB">教材のご案内</span></a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
  <section id="top_about-01" class="top_about-01">
    <div class="bg">
      <img src="<?php echo get_template_directory_uri(); ?>/images/common/ico-wave.svg" alt="bg" class="_over-TB">
      <img src="<?php echo get_template_directory_uri(); ?>/images/common/ico-wave-sp.svg" alt="bg" class="_only-SP">
    </div>
    <div class="global_inner">
      <div class="titleBox">
        <h2 class="top_title-01 _small _left">
          <span class="title-main">About</span>
          <span class="title-sub">日本スパ・ウエルネス協会について</span>
        </h2>
      </div>
      <div class="contentsBox">
        <?php $aboutText = get_field("top_about_text");  ?>
        <?php if($aboutText): ?><div class="top_text-01"><?php echo $aboutText; ?></div><?php endif; ?>
        <div class="wp-block-buttons">
          <div class="wp-block-button"><a href="/about/" class="wp-block-button__link"><span>日本スパ・ウエルネス協会とは</span></a></div>
        </div>
      </div>
    </div>
  </section>
    <section id="top_certification-01" class="top_certification-01">
    <div class="global_inner">
      <h2 class="top_title-01">
        <span class="title-main">Certification List</span>
        <span class="title-sub">認定試験のご紹介</span>
        <span class="icon">
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
          <?php get_template_part( '/images/ico/ico', 'star' ); ?>
        </span>
      </h2>
      <div class="top_text-01">当協会では、スパ・ウエルネス分野における専門性を高めるための多彩な資格をご用意しています。</div>
      <div class="slider">
        <div class="list_swiper-container">
          <?php
          $arg = array(
            'posts_per_page' => 6,
            'has_password' => false,
            'post_type' => 'certificationslist',
            'orderby' => 'date',
            'order' => 'DESC'
          );
          $query = new WP_Query($arg);
          if ($query->have_posts()): ?>
            <?php get_template_part('list', 'certificationList', [
              'is_slider' => true,
              'query' => $query,
            ]); ?>
          <?php else: ?>
            <p>現在、認定試験のご紹介はありません。</p>
          <?php endif; ?>
        </div>
        <div class="button">
          <div class="swiper-button-prev list-button-prev">
            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="50" height="50" rx="25" fill="#3C6FAC"/>
              <path d="M16 27.5H34L29 22.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="swiper-button-next list-button-next">
            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="50" height="50" rx="25" fill="#3C6FAC"/>
              <path d="M16 27.5H34L29 22.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
      </div>
      <?php if(have_rows('top_certificationList_button')): ?>
        <div class="buttonBox">
          <div class="wp-block-buttons">
            <?php while(have_rows('top_certificationList_button')): the_row(); ?>
              <?php
                $type = get_sub_field('type');
                $title = get_sub_field('title');
                $url = get_sub_field('url');
                $target = get_sub_field('target');
                $file = get_sub_field('file');
                if($type === "_file"){
                  $url = $file;
                  $target = true;
                }
              ?>
              <div class="wp-block-button">
                <a class="wp-block-button__link" href="<?php echo $url; ?>" <?php if( $target ): ?>target="_blank"<?php endif; //外部リンク ?>><span><?php echo $title; ?></span></a>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>
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
  <?php if(have_rows('top_link_box') || have_rows('top_link_banner')): ?>
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
          <?php while(have_rows('top_link_box')): the_row(); ?>
            <?php
              $title = get_sub_field('title');
              $text = get_sub_field('text');
              $img = get_sub_field('img');
              $thumb = wp_get_attachment_image_src($img, 'full');
              $alt = get_post_meta($img, '_wp_attachment_image_alt', true);
              $alt = $alt ? $alt : "image";
            ?>
            <div class="wrap">
              <div class="inner">
                <div class="titleBox">
                  <h3 class="title"><span><?php echo $title; ?></span></h3>
                </div>
                <?php if($img): ?>
                  <div class="imageBox">
                    <div class="image">
                      <img src="<?php echo $thumb[0]; ?>" alt="<?php echo $alt; ?>">
                    </div>
                  </div>
                <?php endif; ?>
                <div class="contentsBox">
                  <?php if($text): ?>
                    <div class="text"><?php echo $text; ?></div>
                  <?php endif; ?>
                  <?php if(have_rows('button')): ?>
                    <div class="module_button --small">
                      <?php while(have_rows('button')): the_row(); ?>
                        <?php
                          $type = get_sub_field('type');
                          $title = get_sub_field('title');
                          $url = get_sub_field('url');
                          $target = get_sub_field('target');
                          $file = get_sub_field('file');
                          if($type === "_file"){
                            $url = $file;
                            $target = true;
                          }
                        ?>
                        <a class="_blue" href="<?php echo $url; ?>" <?php if( $target ): ?>target="_blank"<?php endif; //外部リンク ?>><span><?php echo $title; ?></span></a>
                      <?php endwhile; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
          <?php if(have_rows('top_link_banner')): ?>
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
                  <?php while(have_rows('top_link_banner')): the_row(); ?>
                    <?php
                      $url = get_sub_field('url');
                      $target = get_sub_field('target');
                      
                      $img = get_sub_field('img');
                      $thumb = wp_get_attachment_image_src($img, 'full');
                      $alt = get_post_meta($img, '_wp_attachment_image_alt', true);
                      $alt = $alt ? $alt : "image";
                    ?>
                  <a href="<?php echo $url; ?>" <?php if( $target ): ?>target="_blank"<?php endif; //外部リンク ?>>
                    <img src="<?php echo $thumb[0]; ?>" alt="<?php echo $alt; ?>">
                  </a>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php get_footer(); ?>