<?php
$buttonType = get_field('button-type');
$buttonAlign = get_field('button-align');
?>
<?php if (have_rows('button')) : ?>
  <div class="module_button <?php echo $buttonType ? '' . esc_html($buttonType) : ''; ?> <?php echo $buttonAlign ? '' . esc_html($buttonAlign) : ''; ?>">
    <?php while (have_rows('button')) : the_row(); ?>
      <?php
      $type = get_sub_field('type');
      $title = get_sub_field('title');
      $url = get_sub_field('url');
      $target = get_sub_field('target');
      $file = get_sub_field('file');
      if($buttonType === "--anchor") {
        $url = '#' . ltrim($url, '#');
        $target = false;
      }
      if ($type === "_file" && $file && $buttonType !== "--anchor") {
        $url = $file;
        $target = true;
      }
      ?>
      <a href="<?php echo $url ? esc_url($url) : ''; ?>" <?php echo $target ? 'target="_blank"' : ''; ?> class="<?php echo $url ? '' : 'is-disabled'; ?>">
        <span><?php echo nl2br(esc_html($title)); ?></span>
      </a>
    <?php endwhile; ?>
  </div>
<?php endif; ?>