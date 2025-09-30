<?php
//  $noImage =  esc_url(get_template_directory_uri())."/images/common/noimage_visual-01.webp";
$current_post_type = get_post_type();
// 投稿タイプが取得できない場合、URLから推測
if (!$current_post_type) {
  // 現在のURLを取得
  $current_url = $_SERVER['REQUEST_URI'];
  // URLからパスの最初の部分を取得（例: /event/ → event）
  $url_parts = explode('/', trim($current_url, '/'));
  $url_segment = isset($url_parts[0]) ? $url_parts[0] : '';
  
  // URLセグメントから投稿タイプを推測
  if ($url_segment === 'news') {
    $current_post_type = 'post'; // ニュースは通常投稿
  } else {
    // 投稿タイプが実際に存在するかチェック
    if (post_type_exists($url_segment)) {
      $current_post_type = $url_segment;
    } else {
      $current_post_type = 'post'; // デフォルト
    }
  }
}
$postTopId = get_option( 'page_for_posts' );
?>
<?php if (get_post_type()&&!is_page()&&!is_404()&&!is_search()||is_post_type_archive()||is_tax()): //投稿 ?>
  <?php
  $post_type_object = get_post_type_object($current_post_type);
  $postTypeSlug = $post_type_object ? esc_html($post_type_object->name) : 'post';
  $en = get_post_type() === 'post' ? get_post_field( 'post_name', $postTopId): $postTypeSlug;
  $field_name = 'page_img-'.$postTypeSlug; //ビジュアル設定（投稿タイプ）名前に合わせる
  $img = get_field($field_name, 'option');
  $thumb = wp_get_attachment_image_src($img,'head_img');
  //  $thumb[0] = $img ? $thumb[0] : $noImage;
  ?>
  <div class="global_mainVisual <?php if(!$img): ?>_imageNone<?php endif; ?>">
    <div class="global_inner">
      <?php if (!is_single()): ?>
        <div class="gm_box">
            <!-- 投稿タイプ名を表示 -->
            <h1 class="gm_title">
            <span>
              <?php
              // すでに取得済みの$post_type_objectを使用（エラー対策）
              // 投稿タイプのラベル（日本語名など）を表示
              if ($post_type_object && isset($post_type_object->labels->singular_name)) {
                echo esc_html($post_type_object->labels->singular_name);
              } else {
                echo esc_html(get_the_title($postTopId));
              }
              ?>
            </span>
            </h1>
        </div>
      <?php else: ?>
        <div class="gm_box">
          <p class="gm_title"><span><?php echo get_archive_title(); ?></span></p>
        </div>
      <?php endif; ?>
      <?php if($img): ?>
        <div class="gm_background">
          <img src="<?php echo $thumb[0];?>" alt="<?php echo strip_tags(get_the_title()); ?>">
        </div>
      <?php endif; ?>
    </div><!-- /global_inner -->
  </div><!-- /global_mainVisual -->
<?php elseif (is_404()): //404 ?>
  <?php
  $img = get_field('page_img-other', 'option');
  $thumb = wp_get_attachment_image_src($img,'head_img');
  //  $thumb[0] = $img ? $thumb[0] : $noImage;
  ?>
  <div class="global_mainVisual <?php if(!$img): ?>_imageNone<?php endif; ?>">
    <div class="global_inner">
      <div class="gm_box">
        <h1 class="gm_title"><span>お探しのページは<br>見つかりませんでした</span></h1>
      </div>
      <?php if($img): ?>
        <div class="gm_background">
          <img src="<?php echo $thumb[0];?>" alt="<?php the_title(); ?>">
        </div>
      <?php endif; ?>
    </div><!-- /global_inner -->
  </div><!-- /global_mainVisual -->
<?php elseif (is_search()): //検索結果 ?>
  <?php
  $img = get_field('page_img-other', 'option');
  $thumb = wp_get_attachment_image_src($img,'head_img');
  //  $thumb[0] = $img ? $thumb[0] : $noImage;
  ?>
  <div class="global_mainVisual <?php if(!$img): ?>_imageNone<?php endif; ?>">
    <div class="global_inner">
      <div class="gm_box">
        <h1 class="gm_title"><span><?php if ( empty( get_search_query() ) ) : ?>検索キーワードが未入力です<?php else: ?><?php the_search_query(); ?>の検索結果<?php endif; ?></span></h1>
      </div>
      <?php if($img): ?>
        <div class="gm_background">
          <img src="<?php echo $thumb[0];?>" alt="<?php echo strip_tags(get_the_title()); ?>">
        </div>
      <?php endif; ?>
    </div><!-- /global_inner -->
  </div><!-- /global_mainVisual -->
<?php else: ?>
  <?php
  $page = get_post( get_the_ID() );
  if ( $page ) {
    $slug = $page->post_name;
    $title = get_the_title();
  } else {
    $slug = get_post_field( 'post_name', $postTopId);
    $title = get_the_title($postTopId);
  }
  $en = get_field('page_en') ? get_field('page_en') : $slug;
  $img = get_field('page_img');
  $thumb = wp_get_attachment_image_src($img,'head_img');
  //  $thumb[0] = $img ? $thumb[0] : $noImage;
  ?>
  <div class="global_mainVisual <?php if(!$img): ?>_imageNone<?php endif; ?>">
    <div class="global_inner">
      <div class="gm_box">
        <h1 class="gm_title"><span><?php echo $title; ?></span></h1>
      </div>
      <?php if($img): ?>
        <div class="gm_background">
          <img src="<?php echo $thumb[0];?>" alt="<?php echo strip_tags($title); ?>">
        </div>
      <?php endif; ?>
    </div><!-- /global_inner -->
  </div><!-- /global_mainVisual -->
<?php endif; //分岐終了 ?>
<?php get_template_part( 'breadCrumb' ); ?>