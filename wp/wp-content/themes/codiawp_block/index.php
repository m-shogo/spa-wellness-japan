<?php get_header(); ?>
  <main id="global_contents" class="global_contents" itemscope itemprop="mainContentOfPage">
    <section>
      <?php get_template_part( 'visual' ); ?>
      <div class="global_inner _column">
        <div class="gc_main">
          <?php get_template_part( 'list','news' ); ?>
        </div>
        <aside class="gc_sub">
          <?php get_sidebar('archive'); ?>
        </aside>
      </div>
    </section>
  </main>
<?php get_footer(); ?>