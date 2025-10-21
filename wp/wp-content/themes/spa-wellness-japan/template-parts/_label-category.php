<?php
$taxonomy = $args['taxonomy'] ?? '';

if (get_post_type() === 'post'): // 通常投稿
  if ($taxonomy === '_cat' || empty($taxonomy)) {
    $category = get_the_category();
    $name = 'cat_name';
  } else {
    $category = get_the_tags();
    $name = 'name';
  }
  // 配列・要素ありのときだけ描画
  if (is_array($category) && !empty($category)): ?>
    <p class="category <?php echo esc_attr($taxonomy); ?>">
      <?php foreach ($category as $cat) {
        $parent_slug = '';
        $parent = isset($cat->category_parent) ? (int) $cat->category_parent : 0;
        if ($parent) {
          $parent_term = get_term($parent);
          if (!is_wp_error($parent_term) && $parent_term) {
            $parent_slug = ' _' . $parent_term->slug;
          }
        }
        // タグ（name）/カテゴリー（cat_name）どちらでも安全に取得
        $label = isset($cat->$name) ? $cat->$name : '';
        echo '<span class="label ' . esc_attr($cat->slug) . $parent_slug . '">' . esc_html($label) . '</span>';
      } ?>
    </p>
  <?php endif; // $category
else: // その他カスタム投稿
  if (empty($taxonomy)) {
    $taxonomy = '_cat';
  }
  // null対策：オブジェクトが取得できなければスラッグ文字列にフォールバック
  $post_type_str = get_post_type();
  $post_type_obj = $post_type_str ? get_post_type_object($post_type_str) : null;
  $postType = ($post_type_obj && isset($post_type_obj->name)) ? $post_type_obj->name : $post_type_str;

  $postType_cat = $postType . $taxonomy;
  // $post->ID ではなく get_the_ID() を使用（intに対する->ID回避）
  $terms = get_the_terms(get_the_ID(), $postType_cat);
  if ($terms && !is_wp_error($terms)): ?>
    <p class="category <?php echo esc_attr($taxonomy); ?>">
      <?php foreach ($terms as $term) {
        $parent_slug = '';
        $parent = isset($term->parent) ? (int) $term->parent : 0;
        if ($parent) {
          $parent_term = get_term($parent);
          if (!is_wp_error($parent_term) && $parent_term) {
            $parent_slug = ' _' . $parent_term->slug;
          }
        }
        echo '<span class="label ' . esc_attr($term->slug) . $parent_slug . '">' . esc_html($term->name) . '</span>';
      } ?>
    </p>
  <?php endif; // $terms
endif;
?>