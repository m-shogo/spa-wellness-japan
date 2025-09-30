<?php

/**
 * Template Name: 1カラムテンプレート
 */
global $post;
get_header(); ?>
<main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
  <?php if (!post_password_required($post->ID)) :  ?>
    <section>
      <?php get_template_part('visual'); ?>
      <div class="content_inner">
        <div class="gc_main _oneColumn">
          <div class="block-editor_wrap">
            <?php the_content(); ?>
          </div>
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