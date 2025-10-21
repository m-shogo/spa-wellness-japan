<?php
global $post; // $post をグローバルスコープに取り込む
if (get_post_type() === 'post'): //通常投稿 ?>
  <?php
  if($taxonomy === '_cat' || empty($taxonomy)){
    $category = get_the_category();
    $name = 'cat_name';
  } else {
    $category = get_the_tags();
    $name = 'name';
  }
  // 配列かどうかもチェック（エラー・空配列・falseを防ぐ）
  if (!is_wp_error($category) && is_array($category) && count($category) > 0): ?>
    <p class="category <?php echo $taxonomy; ?>">
      <?php foreach( $category as $cat ){
        $parent = $cat->category_parent;
        if ($parent) {
          $parent_term = get_term($parent);
          if (!is_wp_error($parent_term)) {
            $parent_slug = $parent_term->slug;
            $parent_slug = ' _'.$parent_slug;
          }
        }
        $cat_id = $cat->term_id;
        $color_id = 'category_'.$cat_id;
        $color = get_field('category_color',$color_id);
        echo '<span class="label '.esc_html($cat->slug).''.($parent ? $parent_slug : '').'">'.esc_html($cat->$name).'</span>'; } ?></p>
  <?php endif; //$category ?>
<?php else: //その他カスタム投稿 ?>
  <?php
  if(empty($taxonomy)){
    $taxonomy = '_cat';
  }
  $postType = esc_html(get_post_type_object(get_post_type())->name);
  $postType_cat = $postType.$taxonomy;
  $terms = get_the_terms($post->ID, $postType_cat);
  if ($terms && !is_wp_error($terms) && is_array($terms) && count($terms) > 0): ?>
    <p class="category <?php echo '_'.$postType; ?>">
      <?php foreach ( $terms as $term ) {
        $parent = $term->parent;
        if ($parent) {
          $parent_term = get_term($parent);
          if (!is_wp_error($parent_term)) {
            $parent_slug = $parent_term->slug;
            $parent_slug = ' _'.$parent_slug;
          }
        }
        $cat_id = $term->term_id;
        $color_id = $postType_cat.'_'.$cat_id;
        $color = get_field('category_color',$color_id);
        echo '<span class="label '.esc_html($term->slug).''.($parent ? $parent_slug : '').'">'.esc_html($term->name).'</span>'; } ?></p>
  <?php endif; //$terms ?>
<?php endif; //分岐終了 ?>