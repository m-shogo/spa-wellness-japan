<?php
$post_type = 'certificationslist';
$taxonomies = "{$post_type}_cat";
$args = array(
  'orderby' => 'id',
  'hide_empty' => true, // 投稿がないカテゴリを出すかどうか
  'parent' => 0,
);
$terms = get_terms( $taxonomies, $args );
?>
<?php foreach( $terms as $term ) : ?>
  <?php $slug = $term->slug; ?>
  <h3 class="wp-block-heading"><?php echo $term->name; ?></h3>
  <?php
  $arg = array(
    'has_password' => false,
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type'      => $post_type,  // カスタム投稿タイプ名
    'tax_query'      => array(
      array(
        'taxonomy' => $taxonomies,  // カスタムタクソノミー名
        'field'    => 'slug',  // ターム名を term_id,slug,name のどれで指定するか
        'terms'    => $slug // タクソノミーに属するslug
      )
    )
  );
  $posts = new WP_Query( $arg );
  ?>
  <?php if ($posts->have_posts()) :?>
    <ul class="module_accordion-01 _certificationslist">
      <?php while ($posts->have_posts()) : $posts->the_post(); ?>
      <?php $post_id = get_the_ID(); ?>
        <li id="<?php echo esc_attr($slug . '_' . $post_id); ?>" class="accordion">
          <div class="head">
            <div class="title"><?php the_title(); ?></div>
            <div class="button"><span></span></div>
          </div>
          <div class="body" style="display: none;">
            <div class="text">
              <?php the_content(); ?>
              <?php if(have_rows('certificationslist_button', $post_id )): ?>
                <div class="module_button --small _column">
                  <?php while(have_rows('certificationslist_button', $post_id )): the_row(); ?>
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
                    <a href="<?php echo $url; ?>" <?php if( $target ): ?>target="_blank"<?php endif; //外部リンク ?>><span><?php echo $title; ?></span></a>
                  <?php endwhile; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php endif; ?>
<?php endforeach; ?>