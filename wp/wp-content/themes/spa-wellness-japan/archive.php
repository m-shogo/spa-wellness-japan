<?php get_header(); ?>
  <main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
    <section>
      <?php get_template_part( 'visual' ); ?>
      <?php if (get_post_type() === 'post'||is_category()): //通常投稿 ?>
        <?php get_sidebar('archive'); ?>
        <div class="content_inner">
          <div class="gc_main _oneColumn">
            <?php get_template_part( 'list','news' ); ?>
          </div>
        </div>
      <?php else: //その他カスタム投稿 ?>
        <div class="global_inner">
          <div class="gc_main _oneColumn">
            <?php get_sidebar('archive'); ?>
            <?php get_template_part( 'list','card' ); ?>
          </div>
        </div>
      <?php endif; ?>
    </section>
  </main>
<?php get_footer(); ?>