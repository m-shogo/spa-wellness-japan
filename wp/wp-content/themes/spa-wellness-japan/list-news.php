<?php
global $post, $posts, $wp_query;
if (is_front_page() || is_page()): ?>
  <div class="module_newsList-01">
    <?php foreach ($posts as $post): setup_postdata($post); ?>
      <article>
        <?php
        $post_id = get_the_ID();
        $post_type = get_field('post_type', $post_id);
        $url = get_permalink();
        $target = false;
        if ($post_type) {
          if ($post_type === 'post') {
            $url = get_permalink();
          } elseif ($post_type === 'url') {
            $url  = get_field('postType_url', $post_id);
            $target  = get_field('postType_target', $post_id);
          } elseif ($post_type === 'file') {
            $url  = get_field('postType_file', $post_id);
            $target = true;
          }
        } ?>
        <a href="<?php echo $url; ?>" <?php if ($target): ?> target="_blank" <?php endif; ?>>
          <div class="head">
            <p class="date"><time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time></p>
            <?php
            get_template_part('template-parts/_label-category', null, [
              'taxonomy' => '_cat',
            ]);
            ?>
          </div>
          <div class="body">
            <h3 class="title"><?php the_title(); ?></h3>
          </div>
        </a>
      </article>

    <?php endforeach;
    wp_reset_postdata(); ?>
  </div>
<?php else: ?>
  <?php if (have_posts()): ?>
    <div class="module_newsList-01">
      <?php while (have_posts()) : the_post(); ?>
        <article>
          <?php
          $post_id = get_the_ID();
          $post_type = get_field('post_type', $post_id);
          $url = get_permalink();
          $target = false;
          if ($post_type) {
            if ($post_type === 'post') {
              $url = get_permalink();
            } elseif ($post_type === 'url') {
              $url  = get_field('postType_url', $post_id);
              $target  = get_field('postType_target', $post_id);
            } elseif ($post_type === 'file') {
              $url  = get_field('postType_file', $post_id);
              $target = true;
            }
          } ?>
          <a href="<?php echo $url; ?>" <?php if ($target): ?> target="_blank" <?php endif; ?>>
            <div class="head">
              <p class="date"><time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time></p>
              <?php
              get_template_part('template-parts/_label-category', null, [
                'taxonomy' => '_cat',
              ]);
              ?>
            </div>
            <div class="body">
              <h2 class="title"><?php the_title(); ?></h2>
            </div>
          </a>
        </article>
      <?php endwhile; ?>
    </div>
    <?php
    // ページネーション（アーカイブページのみ）
    if (!is_front_page() && !is_page() && !is_single() && is_main_query() && function_exists('responsive_pagination')) {
      responsive_pagination($wp_query->max_num_pages);
    }
    ?>
  <?php else: ?>
    <p>お知らせはありません。</p>
  <?php endif; ?>
<?php endif; ?>