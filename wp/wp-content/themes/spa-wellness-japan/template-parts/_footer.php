<footer id="global_footer" class="global_footer" itemscope itemtype="https://schema.org/WPFooter">
  <div class="gf_links-wrap">
    <ul class="gf_links-01 module_menu-01">
      <?php if (have_rows('common-menu-01', 'option')): ?>
        <?php while (have_rows('common-menu-01', 'option')): the_row(); ?>
          <?php
          $title01 = get_sub_field('title-01');
          $url01 = get_sub_field('url-01');
          $target01 = get_sub_field('target-01');
          $footer = get_sub_field('hide-footer');
          $select01 = get_sub_field('select-01');
          ?>
          <?php if ($footer): ?>
            <?php if ($select01): ?>
              <li>
                <button class="gfl_button mm_button" type="button"><span>開閉</span></button>
                <a class="gfl_title mm_title" href="<?php echo $url01; ?>" <?php if ($target01): ?>target="_blank" <?php endif; ?>><?php echo $title01; ?></a>
                <div class="gfl_wrapper mm_wrapper-01">
                  <div class="gfl_inner mm_inner-01">
                    <ul>
                      <?php if (have_rows('hierarchy-02', 'option')): ?>
                        <?php while (have_rows('hierarchy-02', 'option')): the_row(); ?>
                          <?php
                          $title02 = get_sub_field('title-02');
                          $url02 = get_sub_field('url-02');
                          $target02 = get_sub_field('target-02');
                          $select02 = get_sub_field('select-02'); //4階層目なしの場合削除し、if( $select02 )内の4階層目なし<li>のみwhile内に残す
                          ?>
                          <?php if ($select02): ?>
                            <li>
                              <button class="gfl_button mm_button-01" type="button"><span>開閉</span></button>
                              <a class="gfl_title mm_title-01" href="<?php echo $url02; ?>" <?php if ($target02): ?>target="_blank" <?php endif; ?>><?php echo $title02; ?></a>
                              <div class="gfl_wrapper mm_wrapper-02">
                                <div class="gfl_inner mm_inner-02">
                                  <ul>
                                    <?php if (have_rows('hierarchy-03', 'option')): ?>
                                      <?php while (have_rows('hierarchy-03', 'option')): the_row(); ?>
                                        <?php
                                        $title03 = get_sub_field('title-03');
                                        $url03 = get_sub_field('url-03');
                                        $target03 = get_sub_field('target-03');
                                        ?>
                                        <li><a class="gfl_title mm_title-02" href="<?php echo $url03; ?>" <?php if ($target03): ?>target="_blank" <?php endif; ?>><?php echo $title03; ?></a></li>
                                      <?php endwhile; ?>
                                    <?php endif; ?>
                                  </ul>
                                </div>
                              </div>
                            </li>
                          <?php else: ?>
                            <li><a class="gfl_title mm_title-01" href="<?php echo $url02; ?>" <?php if ($target02): ?>target="_blank" <?php endif; ?>><?php echo $title02; ?></a></li>
                          <?php endif; ?>
                        <?php endwhile; ?>
                      <?php endif; ?>
                    </ul>
                  </div>
                </div>
              </li>
            <?php else: ?>
              <li>
                <a class="gfl_title mm_title" href="<?php echo $url01; ?>" <?php if ($target01): ?>target="_blank" <?php endif; ?>><?php echo $title01; ?></a>
              </li>
            <?php endif; ?>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </ul>
    <ul class="gf_links-02 module_menu-02">
      <?php if (have_rows('common-submenu-01', 'option')): ?>
        <?php while (have_rows('common-submenu-01', 'option')): the_row(); ?>
          <?php
          $title = get_sub_field('title');
          $url = get_sub_field('url');
          $target = get_sub_field('target');
          $footer = get_sub_field('hide-footer');
          ?>
          <?php if ($footer): ?>
            <li><a href="<?php echo $url; ?>" <?php if ($target): ?>target="_blank" <?php endif; ?>><?php echo $title; ?></a></li>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </ul>
  </div>
  <div class="gf_information">
    <div class="global_inner">
      <p class="gf_logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/common/logo.svg" alt="<?php bloginfo('name'); ?>"></a></p>
      <address>
        <p class="gf_address">〒000-0000<br>東京都テスト区テスト町1-1-1</p>
        <p class="gf_tel">TEL:<a href="tel:00-0000-0000">00-0000-0000</a></p>
      </address>
    </div>
  </div>
  <p id="js_gf_pageTop" class="gf_pageTop"><a href="#"><span>ページトップへ戻る</span></a></p>
  <p class="gf_copyright"><span>&copy; 2025 Codia Corporation.</span></p>
</footer>