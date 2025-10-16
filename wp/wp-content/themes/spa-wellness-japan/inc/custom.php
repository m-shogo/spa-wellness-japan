<?php

/**
 * --------------------------------------------------------------------------------
 * 
 * カスタム投稿タイプ・タクソノミーの設定
 * 
 * --------------------------------------------------------------------------------
 */

// ==========================================================================
// カスタムポストの設定
// ==========================================================================
function add_custom_post()
{
  $args = array(
    'label' => '資格・検定',
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'has_archive' => true,
    'show_in_rest' => true,
    'rewrite' => array('with_front' => false),
    'supports' => array(
      'title',
      'thumbnail',
      'editor',
      'revisions',
    )
  );
  register_post_type('certificationslist', $args);
}
add_action('init', 'add_custom_post');

// ==========================================================================
// カスタムタクソノミーの設定
// ==========================================================================
function add_custom_taxonomy()
{
  register_taxonomy(
    'certificationslist_cat',
    'certificationslist',
    array(
      'label' => 'カテゴリー',
      'hierarchical' => true,
      'public' => true,
      'show_admin_column' => true,
      'show_in_rest'      => true,
      'rewrite' => array('slug' => 'category', 'with_front' => false)
    )
  );
}
add_action('init', 'add_custom_taxonomy');

// ==========================================================================
// 特定の投稿タイプのエディターを非表示にする
// ==========================================================================
// add_action('init', function () {
//   // エディターを無効化するカスタム投稿タイプのリスト
//   $post_types_without_editor = array(
//     'XXXXX', // カスタム投稿名
//   );

//   // 各投稿タイプに対してエディターを削除
//   foreach ($post_types_without_editor as $post_type) {
//     remove_post_type_support($post_type, 'editor');
//   }
// }, 99);

// ==========================================================================
// フロントページのエディターを非表示にする
// ==========================================================================
add_action('admin_init', function () {
  // フロントページのIDを取得
  $front_page_id = get_option('page_on_front');

  // 現在の編集画面がフロントページか判定
  global $pagenow;
  if ($pagenow === 'post.php' && isset($_GET['post']) && intval($_GET['post']) === intval($front_page_id)) {
    remove_post_type_support('page', 'editor');
  }
});

// ==========================================================================
// 投稿タイプ表示件数指定
// ==========================================================================
function hwl_home_pagesize($query)
{
  if (is_admin() || !$query->is_main_query())
    return;
  // if (is_post_type_archive('post')) {
  //   $query->set('posts_per_page', 10);
  //   return;
  // }
  // if (is_post_type_archive('event')) {
  //   $query->set('posts_per_page', 9);
  //   return;
  // }
}
add_action('pre_get_posts', 'hwl_home_pagesize', 1);

// ==========================================================================
// 「投稿」の名称変更
// ==========================================================================
function change_post_menu_label()
{
  global $menu;
  global $submenu;
  $name = '協会からのお知らせ';
  if (isset($menu[5])) {
    $menu[5][0] = $name;
  }
  if (isset($submenu['edit.php'][5])) {
    $submenu['edit.php'][5][0] = $name . '一覧';
  }
  if (isset($submenu['edit.php'][10])) {
    $submenu['edit.php'][10][0] = '新しい' . $name;
  }
  if (isset($submenu['edit.php'][16])) {
    $submenu['edit.php'][16][0] = 'タグ';
  }
}

function change_post_object_label()
{
  global $wp_post_types;
  $name = '協会からのお知らせ';
  $labels = &$wp_post_types['post']->labels;
  $labels->name = $name;
  $labels->singular_name = $name;
  $labels->add_new = _x('追加', $name);
  $labels->add_new_item = $name . 'の新規追加';
  $labels->edit_item = $name . 'の編集';
  $labels->new_item = '新規新' . $name;
  $labels->view_item = $name . 'を表示';
  $labels->search_items = $name . 'を検索';
  $labels->not_found = '記事が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
}

add_action('init', 'change_post_object_label');
add_action('admin_menu', 'change_post_menu_label');

// ==========================================================================
// WordPress 投稿が0件でもpost_typeを取得
// ==========================================================================
function get_current_post_type()
{
  $post_type = get_post_type();

  if (empty($post_type)) {
    // 投稿が 0 件の時
    if (is_category()) {
      $tax = get_taxonomy('category');
      $post_type = $tax->object_type[0];
    } else
        if (is_tax()) {
      // category, taxonomy get_query_var( 'post_type' ) は常に null
      // 投稿が 1件 でもあれば　get_post_type() で取得可能
      $term = get_query_var('taxonomy');
      $tax = get_taxonomy($term);
      $post_type = $tax->object_type[0];
    } else
          if (is_archive()) {
      // 投稿が 0 件の時 get_post_type() は false を返すので get_query_var() で取得する
      $post_type = get_query_var('post_type');
    } else
            if (is_home()) {
      // 投稿の一覧で投稿が0件の時は 'post' を設定
      $post_type = 'post';
    }
  }
  return $post_type;
}

// ==========================================================================
// エスケープ除外用変数（特定のHTMLタグとそれぞれのタグで許可される属性を定義）
// 【使い方例】
// $allowed_html = get_allowed_html();
// $user_input = '<a href="https://example.com" onclick="alert(1)">Click me!</a>';
// $sanitized_output = wp_kses($user_input, $allowed_html);
// ==========================================================================
function get_allowed_html()
{
  return array(
    'a' => array(
      'href' => array(),
      'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array()
  );
}

// ==========================================================================
// カスタム投稿のスラッグからラベルを取得する
// ==========================================================================
function get_post_type_label_by_slug($slug)
{
  $post_types = get_post_types(array(), 'objects'); // 全ての投稿タイプオブジェクトを取得
  foreach ($post_types as $post_type) {

    if (is_array($post_type->rewrite) && $post_type->rewrite['slug'] === $slug) {
      return $post_type->label; // その投稿タイプのラベルを返す
    }
  }
  return null; // マッチするものがなければnullを返す
}

// ==========================================================================
// 特定のカスタム投稿タイプに「固定表示」機能を追加＆表示件数の指定（通常のアーカイブページのみ）
// ==========================================================================
class CustomStickyPosts
{
  private $post_type;
  private $posts_per_page;

  /**
   * コンストラクタ
   */
  public function __construct($post_type, $posts_per_page = 9)
  {
    $this->post_type = $post_type;
    $this->posts_per_page = $posts_per_page;
    $this->init();
  }

  /**
   * アクションとフィルターを追加
   */
  private function init()
  {
    // 固定表示用のメタボックス追加
    add_action('add_meta_boxes', [$this, 'add_sticky_meta_box']);

    // 投稿保存時に固定表示状態を保存
    add_action("save_post_{$this->post_type}", [$this, 'save_sticky_status'], 10, 2);

    // アーカイブページのクエリを変更
    add_action('pre_get_posts', [$this, 'modify_archive_query']);

    // ページネーションの総数を調整
    add_filter('found_posts', [$this, 'adjust_pagination'], 10, 2);

    // 管理画面に固定表示の状態を示す列を追加（無くてもいいかも）
    add_filter("manage_{$this->post_type}_posts_columns", [$this, 'add_sticky_column']);

    // カスタム列に値を表示（無くてもいいかも）
    add_action("manage_{$this->post_type}_posts_custom_column", [$this, 'display_sticky_column'], 10, 2);

    // クイック編集にフィールドを追加
    add_action('quick_edit_custom_box', [$this, 'add_quick_edit_sticky_field'], 10, 2);

    // クイック編集での保存処理
    add_action('save_post', [$this, 'save_quick_edit_sticky']);
  }

  /**
   * 固定表示用のメタボックス追加
   */
  public function add_sticky_meta_box()
  {
    add_meta_box(
      'sticky_meta_box',
      '先頭に固定する',
      [$this, 'render_sticky_meta_box'],
      $this->post_type,
      'side',
      'high'
    );
  }

  /**
   * メタボックスの内容をレンダリング
   */
  public function render_sticky_meta_box($post)
  {
    wp_nonce_field('sticky_meta_box', 'sticky_meta_box_nonce'); // セキュリティ対策のためのnonceフィールドを追加
    $is_sticky = get_post_meta($post->ID, '_is_sticky', true) ? 'checked' : ''; // 投稿が固定状態かどうかをチェックし、チェックボックスの状態を設定
    echo '<label><input type="checkbox" name="sticky" value="1" ' . esc_attr($is_sticky) . ' />';
    echo esc_html__('先頭固定表示', 'textdomain');
    echo '</label>';
  }

  /**
   * 投稿の保存時に固定表示状態を保存
   */
  public function save_sticky_status($post_id, $post)
  {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return; // 自動保存の場合は何もしない
    if (!current_user_can('edit_post', $post_id)) return; // 現在のユーザーに編集権限がない場合は何もしない
    if (!isset($_POST['sticky_meta_box_nonce']) || !wp_verify_nonce($_POST['sticky_meta_box_nonce'], 'sticky_meta_box')) return; // nonceが設定されていないか、無効な場合は何もしない

    $is_sticky = isset($_POST['sticky']) ? 1 : 0; // 固定表示のチェックボックスがオンかどうかを確認
    update_post_meta($post_id, '_is_sticky', $is_sticky); // 投稿のメタデータとして固定表示の状態を保存
  }

  /**
   * アーカイブページのクエリを変更
   */
  public function modify_archive_query($query)
  {
    if (
      !is_admin() &&
      $query->is_main_query() &&
      is_post_type_archive($this->post_type) &&
      !is_tax() &&
      !is_year()
    ) {
      $paged = get_query_var('paged') ?: 1; // 現在のページ番号
      $sticky_posts = $this->get_sticky_posts();
      $posts_per_page = $this->posts_per_page;

      if ($paged == 1) {
        // 最初のページの場合、固定表示ではない投稿を取得
        $query->set('post__not_in', $sticky_posts);
        $query->set('posts_per_page', $posts_per_page);

        // 固定表示の投稿を通常の投稿に結合
        add_filter('the_posts', function ($posts, $query) use ($paged, $posts_per_page) {
          return $this->merge_sticky_posts($posts, $query, $paged, $posts_per_page);
        }, 10, 2);
      } else {
        // 2ページ目以降の場合、オフセットを計算して既に表示された投稿を飛ばす
        $offset = ($paged - 1) * $posts_per_page - count($sticky_posts);

        // オフセットがマイナスにならないように調整
        $query->set('offset', max(0, $offset));
        $query->set('post__not_in', $sticky_posts);
        $query->set('posts_per_page', $posts_per_page);

        // 固定表示の投稿を通常の投稿に結合
        add_filter('the_posts', function ($posts, $query) use ($paged, $posts_per_page) {
          return $this->merge_sticky_posts($posts, $query, $paged, $posts_per_page);
        }, 10, 2);
      }
    }
  }

  /**
   * 固定表示投稿を通常の投稿と結合
   */
  public function merge_sticky_posts($posts, $query, $paged, $posts_per_page)
  {
    if ($query->is_main_query() && is_post_type_archive($this->post_type)) {

      $sticky_posts_ids = $this->get_sticky_posts();

      if (count($sticky_posts_ids) === 0) {
        return $posts;
      }

      $sticky_posts = get_posts([
        'post_type' => $this->post_type,
        'post__in' => $sticky_posts_ids,
        'orderby' => 'post__in',
        'posts_per_page' => $this->posts_per_page,
        'offset' => ($paged - 1) * $posts_per_page
      ]);

      return array_slice(array_merge($sticky_posts, $posts), 0, $this->posts_per_page);
    }
    return $posts;
  }

  /**
   * ページネーションの総数を調整
   */
  public function adjust_pagination($found_posts, $query)
  {
    if (
      $query->is_main_query() &&
      is_post_type_archive($this->post_type) &&
      !is_tax() &&
      !is_year()
    ) {
      $found_posts += count($this->get_sticky_posts());
    }
    return $found_posts;
  }

  /**
   * 固定表示投稿のIDを取得
   */
  private function get_sticky_posts()
  {
    return get_posts([
      'post_type' => $this->post_type,
      'meta_key' => '_is_sticky',
      'meta_value' => '1',
      'posts_per_page' => -1,
      'fields' => 'ids',
    ]);
  }

  /**
   * 管理画面に固定表示の状態を示す列を追加（無くてもいいかも）
   */
  public function add_sticky_column($columns)
  {
    $columns['sticky'] = '先頭固定ステータス';
    return $columns;
  }

  /**
   * カスタム列に値を表示（無くてもいいかも）
   */
  public function display_sticky_column($column_name, $post_id)
  {
    if ($column_name == 'sticky') {
      $is_sticky = get_post_meta($post_id, '_is_sticky', true) ? '先頭固定中' : '通常';
      echo esc_html($is_sticky);
    }
  }

  /**
   * クイック編集にフィールドを追加
   */
  public function add_quick_edit_sticky_field($column_name, $post_type)
  {
    if ($column_name != 'sticky' || $post_type != $this->post_type) return;
    wp_nonce_field('quick_edit_sticky', 'quick_edit_sticky_nonce');
?>
    <fieldset class="inline-edit-col-right">
      <div class="inline-edit-col">
        <label class="inline-edit-sticky">
          <input type="checkbox" name="sticky" value="1">
          <span class="checkbox-title"><?php echo esc_html__('この投稿を先頭に固定表示', 'textdomain'); ?></span>
        </label>
      </div>
    </fieldset>
<?php
  }

  /**
   * クイック編集での保存処理
   */
  public function save_quick_edit_sticky($post_id)
  {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (get_post_type($post_id) != $this->post_type) return;
    if (!isset($_POST['quick_edit_sticky_nonce']) || !wp_verify_nonce($_POST['quick_edit_sticky_nonce'], 'quick_edit_sticky')) return;

    $is_sticky = isset($_POST['sticky']) ? 1 : 0; // クイック編集での固定表示のチェックボックスがオンかどうかを確認
    update_post_meta($post_id, '_is_sticky', $is_sticky);
  }
}

/**
 * カスタム投稿タイプに固定表示機能を追加
 */
function initialize_custom_sticky_posts()
{
  new CustomStickyPosts('event');
  //new CustomStickyPosts('hoge', 10); // 表示件数を指定したい時は第二引数に指定してください（例：hogeは10件）
}
//add_action('init', 'initialize_custom_sticky_posts');

// ==========================================================================
// 固定表示を考慮して投稿を取得する関数（サブループ用）
// ==========================================================================
/**
 * 固定表示を考慮して投稿を取得する関数
 * 
 * @param string $post_type 投稿タイプ
 * @param int $posts_per_page 表示件数
 * @param array $additional_args 追加の引数
 * @return array 取得した投稿の配列
 */
function get_posts_with_sticky_first($post_type, $posts_per_page = 10, $additional_args = array())
{
  // 固定表示された記事を取得
  $sticky_args = array(
    'posts_per_page' => -1,
    'post_type' => $post_type,
    'meta_key' => '_is_sticky',
    'meta_value' => '1',
    'orderby' => 'date',
    'order' => 'DESC'
  );

  // 追加の引数をマージ
  $sticky_args = array_merge($sticky_args, $additional_args);

  $sticky_posts = get_posts($sticky_args);
  $sticky_ids = wp_list_pluck($sticky_posts, 'ID');

  // 通常の記事を取得（固定表示記事を除外）
  $normal_args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => $post_type,
    'orderby' => 'date',
    'order' => 'DESC',
    'post__not_in' => $sticky_ids
  );

  // 追加の引数をマージ
  $normal_args = array_merge($normal_args, $additional_args);

  $normal_posts = get_posts($normal_args);

  // 固定表示記事と通常記事を結合して、指定件数までにする
  return array_slice(array_merge($sticky_posts, $normal_posts), 0, $posts_per_page);
}
