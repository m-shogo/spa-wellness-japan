<?php if (get_current_post_type() === 'post'||is_category()): ?>
    <nav class="local_navigation" id="local_navigation">
        <ul class="ln_links-01 module_menu-01">
            <li>
                <a class="lnl_title mm_title" href="#">カテゴリー</a>
                <div class="lnl_wrapper mm_wrapper-01">
                    <div class="lnl_inner mm_inner-01">
                        <ul>
                            <li><a class="lnl_title mm_title-01" href="<?php $postTopId = get_option( 'page_for_posts' ); echo get_permalink($postTopId); ?>"><span>すべて</span></a></li>
                            <?php
                            $args = array(
                                'post_type' => 'post', // 投稿タイプの指定
                                'orderby' => 'id',
                                'hide_empty' => false, // 投稿がないカテゴリを出すかどうか
                                'parent' => 0,
                            );
                            $categories = get_categories( $args );
                            foreach ( $categories as $category ) {
                                //カテゴリのリンクURLを取得
                                $cat_link = get_category_link($category->cat_ID);
                                //子カテゴリのIDを配列で取得。配列の長さを変数に格納
                                $child_cat_num = count(get_term_children($category->cat_ID,'category'));
                                //親カテゴリのリスト出力
                                if($child_cat_num > 0) {
                                    echo '<li class="child"><button class="lnl_button mm_button-01" type="button"><span>開閉</span></button>';
                                }else{
                                    echo '<li>';
                                }
                                echo '<a class="lnl_title mm_title-01" href="' . $cat_link . '"><span>' . $category -> name . '</span></a>';
                                //子カテゴリが存在する場合
                                if($child_cat_num > 0){
                                    echo '<div class="lnl_wrapper mm_wrapper-02"><div class="lnl_inner mm_inner-02"><ul>';
                                    //子カテゴリの一覧取得条件
                                    $category_children_args = array(
                                        'orderby' => 'id',
                                        'hide_empty' => 0,
                                        'parent' => $category->cat_ID,
                                    );
                                    //子カテゴリの一覧取得
                                    $category_children = get_categories($category_children_args);
                                    //子カテゴリの数だけリスト出力
                                    foreach($category_children as $child_val){
                                        $cat_link = get_category_link($child_val -> cat_ID);
                                        echo '<li><a class="lnl_title mm_title-02" href="' . $cat_link . '">' . $child_val -> name . '</a></li>';
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
        <ul class="ln_links-01 module_menu-01">
            <li>
                <a class="lnl_title mm_title" href="#">アーカイブ</a>
                <div class="lnl_wrapper mm_wrapper-01">
                    <div class="lnl_inner mm_inner-01">
                        <ul>
                            <?php $archives = get_archives_by_fiscal_year(); foreach($archives as $archive): ?>
                                <li><a class="lnl_title mm_title-01" href="<?php $postTopId = get_option( 'page_for_posts' ); echo get_permalink($postTopId); ?>date/<?php echo esc_html($archive->year) ?>/"><?php echo esc_html($archive->year) ?>年度</a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
<?php else: // その他カスタム投稿 ?>
    <nav class="archive_navigation" id="archive_navigation">
        <ul class="an_links-01 module_menu-01">
            <li>
                <div class="anl_title mm_title">カテゴリー</div>
                <div class="anl_wrapper mm_wrapper-01">
                    <div class="anl_inner mm_inner-01">
                        <ul>
                            <li><a class="anl_title mm_title-01" href="<?php echo esc_url( home_url( '/' ) ) . get_current_post_type(); ?>/"><span>すべて</span></a></li>
                            <?php
                            // カスタムタクソノミーが存在するか確認
                            if (is_tax()) {
                                $taxonomy = get_query_var('taxonomy');
                                $taxonomyObject = get_taxonomy($taxonomy);

                                if ($taxonomyObject && isset($taxonomyObject->object_type[0])) {
                                    $postType = $taxonomyObject->object_type[0];
                                    $postType_cat = $postType . '_cat';
                                } else {
                                    // デフォルト値を設定
                                    $postType = '';
                                    $postType_cat = '';
                                }
                            } elseif (is_post_type_archive() || is_single()) {
                                $postTypeObject = get_post_type_object(get_post_type());

                                if ($postTypeObject) {
                                    $postType = esc_html($postTypeObject->name);
                                    $postType_cat = $postType . '_cat';
                                } else {
                                    // デフォルト値を設定
                                    $postType = '';
                                    $postType_cat = '';
                                }
                            }
                            if (isset($postType_cat)) {
                                $taxonomies = $postType_cat;
                                $args = array(
                                    'orderby' => 'id',
                                    'hide_empty' => false, // 投稿がないカテゴリを出すかどうか
                                    'parent' => 0,
                                );
                                $terms = get_terms( $taxonomies, $args );
                                if( !empty( $terms ) && !is_wp_error( $terms ) ) {
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
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
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
    </nav>
<?php endif; ?>