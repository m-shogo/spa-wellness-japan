<?php get_header(); ?>
  <main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
    <section>
      <?php get_template_part( 'visual' ); ?>
      <?php get_sidebar('archive'); ?>
      <div class="content_inner">
        <div class="gc_main _oneColumn">
          <?php get_template_part( 'list','news' ); ?>
        </div>
      </div>
    </section>
  </main>
<?php get_footer(); ?>