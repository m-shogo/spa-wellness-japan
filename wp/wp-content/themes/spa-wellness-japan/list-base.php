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
      ?>
      <article class="<?php echo $is_slider ? 'swiper-slide' : ''; ?>">
        <a class="wrap" href="<?php echo $permalink; ?>" <?php if ($target): ?>target="_blank" <?php endif; ?>>
          <div class="inner">
            <div class="imageBox">
              <div class="image <?php if(!$img): ?>_noImage<?php endif; ?>">
                <img src="<?php echo $thumb[0];?>" alt="<?php echo $title; ?>">
              </div>
            </div>
            <div class="contentsBox">
              <p class="date"><time datetime="<?php the_time('Y-m-d'); ?>"><span><?php the_time('Y.m.d');
                    ?></span></time></p>
              <h2 class="title"><?php echo $title; ?></h2>
            </div>
          </div>
        </a>
      </article>
    <?php endwhile; if ($query !== $wp_query) wp_reset_postdata(); ?>
  </div><!-- /module_newsCard-01 -->
<?php else: ?>
  <h2 class="module_title-04"><span>現在、ご覧いただける記事はございません。</span></h2>
<?php endif; ?>

<?php include locate_template( 'pagination.php' ); ?>