<?php
global $post;
get_header(); ?>
<main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
  <?php if (!post_password_required($post->ID)) :  ?>
    <section>
      <?php get_template_part('visual'); ?>
      <div class="content_inner">
        <div class="gc_main _oneColumn">
          <article>
            <div class="module_titleSingle">
              <div class="head">
                <p class="date"><time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y/m/d'); ?></time></p>
                <?php
                get_template_part('template-parts/_label-category', null, [
                  'taxonomy' => '_cat',
                ]);
                ?>
              </div>
              <div class="body">
                <h1 class="module_title-01"><span><?php the_title(); ?></span></h1>
              </div>
            </div>
            <div class="block-editor_wrap">
              <?php the_content(); ?>
            </div>
          </article>
          <ul class="module_pager-02">
            <?php
            $prev_post = get_previous_post(); //前の記事
            $next_post = get_next_post(); //次の記事
            $postType = esc_html(get_post_type_object(get_post_type())->name);
            ?>
            <?php if ($prev_post): // 前の投稿があれば表示 
            ?>
              <li class="prev"><a href="<?php echo get_permalink($prev_post->ID); ?>"><span>前へ</span></a></li>
            <?php else: ?>
              <li class="prev _hidden"><span>前へ</span></li>
            <?php endif; //$prev_post 
            ?>
            <li class="back"><a href="<?php if (get_post_type() === 'post'): $postTopId = get_option('page_for_posts'); ?><?php echo get_permalink($postTopId); ?><?php else: ?><?php echo esc_url(home_url()); ?>/<?php echo $postType; ?>/<?php endif; ?>"><span>一覧</span></a></li>
            <?php if ($next_post): // 次の投稿があれば表示 
            ?>
              <li class="next"><a href="<?php echo get_permalink($next_post->ID); ?>"><span>次へ</span></a></li>
            <?php else: ?>
              <li class="next _hidden"><span>次へ</span></li>
            <?php endif; //$next_post 
            ?>
          </ul>
        </div>
      </div>
    </section>
  <?php else: ?>
    <section>
      <?php get_template_part('visual'); ?>
      <div class="content_inner">
        <div class="module_password">
          <?php echo get_the_password_form(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php get_footer(); ?>