<?php if (get_post_type() === 'post' || is_category() || is_home() || is_tag()): ?>
  <nav class="local_navigation" id="local_navigation">
    <div class="module_select-01 _only-SP">
      <div class="wrap">
        <select name="area">
          <option disabled selected value>カテゴリーを選択</option>
          <option value="<?php echo home_url() ?>/<?php $postTopId = get_option( 'page_for_posts'); echo get_post_field('post_name', $postTopId); ?>/">すべて</option>
          <?php
          // 親カテゴリーのものだけを一覧で取得
          $args = array(
            'post_type' => 'post', // 投稿タイプの指定
            'orderby' => 'id',
            'hide_empty' => true, // 投稿がないカテゴリを出すかどうか
            'parent' => 0,
          );
          $categories = get_categories( $args );
          ?>
          <?php foreach( $categories as $category ) : ?>
            <option value="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="module_category-01 _over-PC">
      <div class="wrap">
        <a class="title" href="<?php echo home_url() ?>/<?php $postTopId = get_option( 'page_for_posts'); echo get_post_field('post_name', $postTopId); ?>/">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M6 0L4.3764 4.3776L0 5.994L4.3764 7.6224L6 12L7.6128 7.6224L12 5.994L7.6128 4.3776L6 0Z" fill="#999999"/>
            </svg>
          </div>
          <span>すべて</span>
        </a>
          <?php
          $args = array(
            'post_type' => 'post', // 投稿タイプの指定
            'orderby' => 'id',
            'hide_empty' => true, // 投稿がないカテゴリを出すかどうか
            'parent' => 0,
          );
          $categories = get_categories( $args );
          foreach ( $categories as $category ) {
            //カテゴリのリンクURLを取得
            $cat_link = get_category_link($category->cat_ID);
            //子カテゴリのIDを配列で取得。配列の長さを変数に格納
            $child_cat_num = count(get_term_children($category->cat_ID,'category'));
            //親カテゴリのリスト出力
            echo '<a class="title" href="' . $cat_link . '"><div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 0L4.3764 4.3776L0 5.994L4.3764 7.6224L6 12L7.6128 7.6224L12 5.994L7.6128 4.3776L6 0Z" fill="#999999"/></svg></div><span>' . $category -> name . '</span></a>';
            //子カテゴリが存在する場合
          }
          ?>
      </div>
    </div>
  </nav>
<?php else: ?><!-- カスタム投稿タイプ -->
<?php
  // 投稿タイプやタクソノミー（分類）の取得
  $postType = '';
  if (is_post_type_archive() || is_single()) {
    $current_post_type = get_post_type();
    $post_type_object = get_post_type_object($current_post_type);
    $postType = $post_type_object ? esc_html($post_type_object->name) : '';
  } elseif (is_tax()) {
    $taxonomy = get_query_var('taxonomy');
    $tax_object = get_taxonomy($taxonomy);
    $postType = ($tax_object && isset($tax_object->object_type[0])) ? $tax_object->object_type[0] : '';
  }

  // 投稿タイプが取得できない場合、URLから推測
  if (!$postType) {
    $current_url = $_SERVER['REQUEST_URI'];
    $url_parts = explode('/', trim($current_url, '/'));
    $url_segment = isset($url_parts[0]) ? $url_parts[0] : '';
    
    if ($url_segment === 'news') {
      $postType = 'post';
    } elseif (post_type_exists($url_segment)) {
      $postType = $url_segment;
    } else {
      $postType = 'post'; // デフォルト
    }
  }

  $postType_cat = $postType . '_cat';
  $postType_tag = $postType . '_tag';

  // 投稿タイプのオブジェクトを取得
  $post_type_obj = get_post_type_object($postType);
  //var_dump($post_type_obj); // デバッグ用
  // ラベル（表示名）とスラッグ（URL用の英語名）を取得
  $postType_label = $post_type_obj ? $post_type_obj->label : '投稿';
  $postType_slug = $post_type_obj ? $post_type_obj->name : 'post';
?>
  <nav class="archive_navigation" id="archive_navigation">
    <div class="module_select-01">
      <div class="wrap">
        <select name="area">
          <option disabled selected value>カテゴリ</option>
          <option value="/<?php echo $postType; ?>/">すべて</option>
          <?php
          $taxonomies = $postType_cat;
          $args = array(
            'orderby' => 'id',
            'hide_empty' => false, // 投稿がないカテゴリを出すかどうか
            'parent' => 0,
          );
          $terms = get_terms( $taxonomies, $args );
          ?>
          <?php foreach( $terms as $term ) : ?>
            <option value="<?php echo get_term_link( $term->term_id ); ?>"><?php echo $term->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <ul class="an_links-01 module_menu-01">
      <li>
        <div class="anl_title mm_title">カテゴリー</div>
        <div class="anl_wrapper mm_wrapper-01">
          <div class="anl_inner mm_inner-01">
            <ul>
              <?php
              $taxonomies = $postType_cat;
              $args = array(
                'orderby' => 'id',
                'hide_empty' => false, // 投稿がないカテゴリを出すかどうか
                'parent' => 0,
              );
              $terms = get_terms( $taxonomies, $args );
              foreach ( $terms as $term ) {
                //カテゴリのリンクURLを取得
                $term_link = get_term_link($term->term_id);
                //子カテゴリのIDを配列で取得。配列の長さを変数に格納
                $child_term_num = count(get_term_children($term->term_id , $taxonomies));
                //親カテゴリのリスト出力
                if($child_term_num > 0) {
                  echo '<li class="child"><button class="anl_button mm_button-01" type="button"><span>開閉</span></button>';
                }else{
                  echo '<li>';
                }
                echo '<a class="anl_title mm_title-01" href="' . $term_link . '"><span>' . $term -> name . '</span></a>';
                //子カテゴリが存在する場合
                if($child_term_num > 0){
                  echo '<div class="anl_wrapper mm_wrapper-02"><div class="anl_inner mm_inner-02"><ul>';
                  //子カテゴリの一覧取得条件
                  $term_children_args = array(
                    'orderby' => 'id',
                    'hide_empty' => 0,
                    'parent' => $term->term_id ,
                  );
                  //子カテゴリの一覧取得
                  $term_children = get_terms( $taxonomies, $term_children_args );
                  //子カテゴリの数だけリスト出力
                  foreach($term_children as $child_val){
                    $term_link = get_term_link($child_val -> term_id);
                    echo '<li><a class="anl_title mm_title-02" href="' . $term_link . '">' . $child_val -> name . '</a></li>';
                  }
                  echo '</ul></div></div>';
                }
                echo '</li>';
              }
              ?>
            </ul>
          </div>
        </div>
      </li>
    </ul>
    <div class="module_select-01 _archive">
      <div class="wrap">
        <select name="area">
          <option disabled selected value>年度別</option>
          <?php $postType = get_post_type( ); $args = array('post_type' => $postType); $archives = get_archives_by_fiscal_year($args); foreach($archives as $archive): ?>
            <option value="/<?php echo $postType; ?>/date/<?php echo esc_html($archive->year) ?>/"><?php echo esc_html($archive->year) ?>年度</option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <ul class="an_links-01 module_menu-01">
      <li>
        <div class="anl_title mm_title">アーカイブ</div>
        <div class="anl_wrapper mm_wrapper-01">
          <div class="anl_inner mm_inner-01">
            <ul>
              <?php $args = array('post_type' => $postType); $archives = get_archives_by_fiscal_year($args); foreach($archives as $archive): ?>
                <li><a class="anl_title mm_title-01" href="<?php echo home_url() ?>/<?php echo $postType; ?>/date/<?php echo esc_html($archive->year) ?>/"><?php echo esc_html($archive->year) ?>年度</a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </li>
    </ul>
    <!-- 年 年度だと使用不可 -->
    <ul class="ln_links-01 module_menu-01 _archive">
      <li>
        <div class="lnl_title mm_title">掲載年から選ぶ</div>
        <div class="lnl_wrapper mm_wrapper-01">
          <div class="lnl_inner mm_inner-01">
            <?php // 年別アーカイブリストを表示
            $postType = esc_html(get_post_type_object(get_post_type())->name);
            $year=NULL; // 年の初期化
            $args = array( // クエリの作成
              'post_type' => $postType, // 投稿タイプの指定
              'orderby' => 'date', // 日付順で表示
              'posts_per_page' => -1 // すべての投稿を表示
            );
            $the_query = new WP_Query($args);
            if($the_query->have_posts()): ?>
              <ul>
                <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                  <?php  if ($year != get_the_date('Y')): ?>
                    <?php $year = get_the_date('Y'); ?>
                    <li><a class="lnl_title mm_title-01" href="<?php if (get_post_type() === 'post'): $postTopId =
                        get_option( 'page_for_posts' ); ?><?php echo get_post_field('post_name', $postTopId); ?><?php else: ?><?php echo esc_url( home_url() ); ?>/<?php echo $postType; ?>/<?php endif; ?><?php echo $year ?>/"><span><?php echo $year ?>年</span></a></li>
                  <?php endif; ?>
                <?php endwhile; ?>
              </ul>
              <?php wp_reset_postdata();  ?>
            <?php endif; ?>
          </div>
        </div>
      </li>
    </ul>
  </nav>
<?php endif; ?>