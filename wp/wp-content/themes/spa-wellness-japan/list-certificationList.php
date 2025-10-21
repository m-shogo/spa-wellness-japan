<?php
// get_template_part(..., ..., $args) からの受け取り
$is_slider = isset($args['is_slider']) ? (bool) $args['is_slider'] : false;
$query     = (isset($args['query']) && $args['query'] instanceof WP_Query)
  ? $args['query']
  : ((isset($posts) && $posts instanceof WP_Query) ? $posts : $wp_query);

if ($query->have_posts()) :?>
  <div class="module_certificationsList-01<?php echo $is_slider ? ' swiper-wrapper' : ''; ?>">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <?php
      $title = get_the_title();
      $certificationslist_text = get_field('certificationslist_text');
      $post_id = get_the_ID();
      ?>
      <?php
        if(empty($taxonomy)){
          $taxonomy = '_cat';
        }
        $postType = esc_html(get_post_type_object(get_post_type())->name);
        $postType_cat = $postType.$taxonomy;
        $terms = get_the_terms($post->ID, $postType_cat);
        if ($terms && !is_wp_error($terms) && is_array($terms) && count($terms) > 0): ?>
          <?php foreach ( $terms as $term ) {
            $slug = $term->slug;
            break;
          } ?>
        <?php endif; //$terms ?>
      <div class="wrap<?php echo $is_slider ? ' swiper-slide' : ''; ?>">
        <div class="inner">
          <div class="contentsBox">
            <a href="/certificationslist/#<?php echo esc_attr($slug . '_' . $post_id); ?>">
              <h2 class="title"><?php echo $title; ?></h2>
              <div class="arrow">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="26" height="26" rx="13" fill="#BCD4EC"/>
                  <path d="M7 14.5H19L15.6667 11.5" stroke="#3C6FAC" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </a>
            <?php if($certificationslist_text): ?>
              <div class="text"><?php echo $certificationslist_text; ?></div>
            <?php endif; ?>
            <?php if (have_rows('certificationslist_button')): ?>
              <div class="wp-block-buttons">
                <?php while (have_rows('certificationslist_button')): the_row(); ?>
                <?php
                  $type = get_sub_field('type');
                  $title = get_sub_field('title');
                  $permalink = get_sub_field('url');
                  $target = get_sub_field('target');
                  if($type === '_file'){
                    $permalink = get_sub_field('file');
                    $target = true;
                  }
                ?>
                  <div class="wp-block-button">
                    <a href="<?php echo esc_url($permalink); ?>" class="wp-block-button__link" <?php echo $target ? 'target="_blank"' : ''; ?>>
                      <?php echo esc_html($title); ?>
                      <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="5" viewBox="0 0 17 5" fill="none">
                        <path d="M0.5 4.5H16.5L12.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </a>
                  </div>
                <?php endwhile; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; if ($query !== $wp_query) wp_reset_postdata(); ?>
  </div><!-- /module_newsCard-01 -->
<?php else: ?>
  <h2 class="module_title-04"><span>現在、ご覧いただける記事はございません。</span></h2>
<?php endif; ?>

<?php include locate_template( 'pagination.php' ); ?>