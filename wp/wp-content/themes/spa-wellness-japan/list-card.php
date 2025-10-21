<?php
// $postsが有効なWP_Queryオブジェクトであるかどうかをチェック
$is_valid_posts = is_a($posts, 'WP_Query') && $posts->have_posts();
$posts_to_display = (is_front_page() || is_page() || is_single() || $is_valid_posts) ? $posts : $wp_query;

if ($posts_to_display->have_posts()) :?>
  <div class="module_newsCard-01">
    <?php while ($posts_to_display->have_posts()) : $posts_to_display->the_post(); ?>
      <?php
      $permalink = get_permalink();
      $select = get_field('permalinkSelect');
      $target = false;
      if($select === '_file'){
        $permalink = get_field('permalinkFile');
        $target = true;
      } elseif($select === '_other'){
        $permalink = get_field('permalinkUrl');
        $target = get_field('permalinkTarget') ? true : false;
      }

      $title = get_the_title();
      $img = get_field('post_img');
      $thumb = wp_get_attachment_image_src($img,'');
      if(!$thumb){
        $thumb = array();
        $thumb[0] = esc_url(get_template_directory_uri())."/images/common/noimage_logo_01.svg";
      }
      $day  = 7; // 表示させる期間の日数を入れます
      $today = date_i18n('U');
      $post_day = get_the_time('U');
      $term = date('U',($today - $post_day)) / 86400;
      $is_new = $day > $term;
      ?>
      <article>
        <a class="wrap" href="<?php echo $permalink; ?>" <?php if ($target): ?>target="_blank" <?php endif; ?>>
          <div class="inner">
            <div class="imageBox">
              <div class="image <?php if(!$img): ?>_noImage<?php endif; ?>">
                <img src="<?php echo $thumb[0];?>" alt="<?php echo $title; ?>">
              </div>
              <?php if ($is_new): ?>
                <p class="module_new-02"><span class="bg"></span><span class="text">NEW</span></p>
              <?php endif; ?>
              <?php $taxonomy = '_cat'; include locate_template( 'label-category.php' ); ?>
            </div>
            <div class="contentsBox">
              <p class="date"><time datetime="<?php the_time('Y-m-d'); ?>"><span><?php the_time('Y.m.d');
                    ?></span></time></p>
              <h2 class="title"><?php echo $title; ?></h2>
            </div>
          </div>
        </a>
      </article>
    <?php endwhile; wp_reset_postdata(); ?>
  </div><!-- /module_newsCard-01 -->
<?php else: ?>
  <h2 class="module_title-04"><span>現在、ご覧いただける記事はございません。</span></h2>
<?php endif; ?>

<?php include locate_template( 'pagination.php' ); ?>