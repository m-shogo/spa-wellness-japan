<?php get_header(); ?>
  <main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
    <section>
      <?php get_template_part( 'visual' ); ?>
      <div class="content_inner">
        <div class="gc_main _oneColumn">
          <div class="block-editor_wrap">
            <?php
              $page = get_page_by_path('certificationslist');
              echo apply_filters('the_content', $page->post_content);
            ?>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php get_footer(); ?>