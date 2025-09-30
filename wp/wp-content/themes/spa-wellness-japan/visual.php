<?php global $post; ?>
<div class="global_mainVisual">
  <div class="global_inner">
    <?php if (get_current_post_type() && !is_page() && !is_404() && !is_search() || is_post_type_archive() || is_tax()): //投稿 
    ?>
      <?php
      $postType_name = esc_html(get_post_type_object(get_post_type())->name);
      $field_name = 'page_img-' . $postType_name; //ビジュアル設定（投稿タイプ）名前に合わせる
      ?>
      <div class="gm_background" style="background-image: url(<?php $img = get_field($field_name, 'option');
                                                              if ($img): ?><?php $thumb = wp_get_attachment_image_src($img, 'head_img');
                                                                            echo $thumb[0]; ?><?php else: ?><?php echo esc_url(get_template_directory_uri()); ?>/images/common/noimage_visual-01.webp<?php endif; ?>)"></div>
      <?php if (!is_single()): ?>
        <h1 class="gm_title"><span><?php echo get_archive_title(); ?></span></h1>
      <?php else: ?>
        <p class="gm_title"><span><?php echo get_archive_title(); ?></span></p>
      <?php endif; ?>
    <?php elseif (is_404()): //404 
    ?>
      <div class="gm_background" style="background-image: url(<?php $img = get_field('page_img-other', 'option');
                                                              if ($img): ?><?php $thumb = wp_get_attachment_image_src($img, 'head_img');
                                                                            echo $thumb[0]; ?><?php else: ?><?php echo esc_url(get_template_directory_uri()); ?>/images/common/noimage_visual-01.webp<?php endif; ?>)"></div>
      <h1 class="gm_title"><span>お探しのページは<br>見つかりませんでした</span></h1>
    <?php elseif (is_search()): //検索結果 
    ?>
      <div class="gm_background" style="background-image: url(<?php $img = get_field('page_img-other', 'option');
                                                              if ($img): ?><?php $thumb = wp_get_attachment_image_src($img, 'head_img');
                                                                            echo $thumb[0]; ?><?php else: ?><?php echo esc_url(get_template_directory_uri()); ?>/images/common/noimage_visual-01.webp<?php endif; ?>)"></div>
      <h1 class="gm_title"><span><?php if (empty(get_search_query())) : ?>検索キーワードが未入力です<?php else: ?><?php the_search_query(); ?>の検索結果<?php endif; ?></span></h1>
    <?php else: ?>
      <div class="gm_background" style="background-image: url(<?php if (get_field('page_img')): ?><?php $img = get_post_meta($post->ID, 'page_img', true);
                                                                                                  $thumb = wp_get_attachment_image_src($img, 'head_img');
                                                                                                  echo $thumb[0]; ?><?php else: ?><?php echo esc_url(get_template_directory_uri()); ?>/images/common/noimage_visual-01.webp<?php endif; ?>)"></div>
      <h1 class="gm_title"><span><?php the_title(); ?></span></h1>
    <?php endif; ?>
  </div>
</div>
<?php get_template_part('breadCrumb'); ?>