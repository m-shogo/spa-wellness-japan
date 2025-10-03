    </div><!-- /global_wrapper -->
    <?php if (!is_front_page() && !is_home()) : ?>
      <?php get_template_part( 'breadCrumb' ); ?>
    <?php endif; ?>
    <?php include get_stylesheet_directory() . '/template-parts/_footer.php'; ?>
    <?php wp_footer(); ?>
    <?php
    $bodyTag_before = get_field('bodyTag_before', 'option');
    if ($bodyTag_before): ?>
        <?php echo $bodyTag_before; ?>
    <?php endif; ?>
    </body>
</html>