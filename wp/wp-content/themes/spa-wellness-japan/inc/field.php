<?php

/**
 * --------------------------------------------------------------------------------
 * 
 * カスタムフィールドの設定
 * 
 * --------------------------------------------------------------------------------
 */

// ==========================================================================
// カスタムフィールドアラート設定
// ==========================================================================
function my_title_required()
{
?>
  <script>
    try {
      jQuery(document).ready(function(jQuery) {
        if ('post' == jQuery('#post_type').val()) {
          jQuery("#post").submit(function(e) {
            if ('' == jQuery('#title').val()) {
              alert('タイトルを入力してください');
              jQuery('#ajax-loading').css('visibility', 'hidden');
              jQuery('#publish').removeClass('button-primary-disabled');
              jQuery('#title').focus();
              return false;
            }
          });
        }
      });

      jQuery(document).ready(function() {
        formmodified = 0;
        jQuery('form *').change(function() {
          formmodified = 1;
        });
        window.onbeforeunload = confirmExit;

        function confirmExit() {
          if (formmodified == 1) {
            return "更新内容が保存されていない可能性があります。";
          }
        }

        jQuery("input[name='publish']").click(function() {
          formmodified = 0;
        });
        jQuery("input[name='save']").click(function() {
          formmodified = 0;
        });
      });
    } catch (e) {}
  </script>
<?php
}
add_action('admin_head-post-new.php', 'my_title_required');
add_action('admin_head-post.php', 'my_title_required');

// ==========================================================================
// カスタムフィールドオプションページ追加
// ==========================================================================
add_action('acf/init', function () {
  if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
      'page_title' => 'メニュー設定',
      'menu_title' => 'メニュー設定',
      'menu_slug'  => 'common_menu',
      'capability' => 'edit_posts',
      'redirect'   => false
    ));
    // acf_add_options_page(array(
    //   'page_title' => 'フッターバナー設定',
    //   'menu_title' => 'フッターバナー設定',
    //   'menu_slug'  => 'common_footer_banner',
    //   'capability' => 'edit_posts',
    //   'redirect'   => false
    // ));
    // acf_add_options_page(array(
    //   'page_title' => 'ビジュアル設定', // 設定ページで表示される名前
    //   'menu_title' => 'ビジュアル設定', // ナビに表示される名前
    //   'menu_slug' => 'common_visual',
    //   'capability' => 'edit_posts',
    //   'redirect' => false
    // ));
    if (current_user_can('administrator')) {
      acf_add_options_page(array(
        'page_title' => 'タグ設定', // 設定ページで表示される名前
        'menu_title' => 'タグ設定', // ナビに表示される名前
        'menu_slug' => 'common_tag',
        'capability' => 'edit_posts',
        'redirect' => false
      ));
    }
  }
});

/**
 * --------------------------------------------------------------------------------
 * 
 * ブロックエディタの設定
 * 
 * --------------------------------------------------------------------------------
 */
// ==========================================================================
// パターン追加
// ==========================================================================
add_action('init', function () {
  // 注釈リストのブロックパターン
  $pattern = [
    "title"       => "注釈リスト",
    "categories"  => ["リスト"], // 必要に応じてカテゴリを変更
    "description" => "先頭に「※」が付く注釈リスト",
    "content"     => '<!-- wp:list {"className":"annotation-list"} -->
      <ul class="annotation-list">
          <li>注釈リストのテキストを入れてください。</li>
          <li>注釈リストのテキストを入れてください。</li>
      </ul>
      <!-- /wp:list -->',
  ];

  register_block_pattern('annotation-list', $pattern);
});

add_action('acf/init', function () {
  if (function_exists('acf_register_block_type')) {
    acf_register_block_type(array(
      'name'              => 'button',
      'description'       => 'ページ内リンクブロック',
      'title'             => 'ページ内リンク',
      'render_template'   => get_template_directory() . '/acf/blocks/button.php',
      'category'          => 'design',
      'icon'              => 'button',
      'keywords'          => array('button', 'ボタン', 'リンク'),
    ));

    acf_register_block_type(array(
      'name'              => 'accordion',
      'description'       => 'アコーディオンブロック',
      'title'             => 'アコーディオン',
      'render_template'   => get_template_directory() . '/acf/blocks/accordion.php',
      'category'          => 'layout',
      'icon'              => 'editor-ul',
      'keywords'          => array('accordion', 'toggle'),
    ));

    // acf_register_block_type(array(
    //   'name'              => 'in-page-link',
    //   'title'             => 'ページ内リンク',
    //   'description'       => 'ページ内リンクブロック',
    //   'render_template'   => get_template_directory() . '/acf/blocks/inPageLink.php',
    //   'category'          => 'layout',
    //   'icon'              => 'admin-links',
    //   'keywords'          => array('link', 'ページ内リンク', 'リンク'),
    // ));

    // acf_register_block_type(array(
    //   'name'              => 'navigation-large',
    //   'title'             => 'ナビゲーション（大）',
    //   'description'       => 'ナビゲーションブロック',
    //   'render_template'   => get_template_directory() . '/acf/blocks/navigationLarge.php',
    //   'category'          => 'layout',
    //   'icon'              => 'admin-links',
    //   'keywords'          => array('link', 'ナビゲーション', 'リンク'),
    // ));

    acf_register_block_type(array(
      'name'              => 'navigation-small',
      'title'             => 'ナビゲーション',
      'description'       => 'ナビゲーションブロック',
      'render_template'   => get_template_directory() . '/acf/blocks/navigationSmall.php',
      'category'          => 'layout',
      'icon'              => 'admin-links',
      'keywords'          => array('link', 'ナビゲーション', 'リンク'),
    ));

    // acf_register_block_type([
    //   'name'              => 'custom-post-list',
    //   'title'             => '投稿の出力',
    //   'description'       => '指定した条件の記事一覧を出力するブロック',
    //   'render_template'   => get_template_directory() . '/acf/blocks/customPostList.php',
    //   'category'          => 'formatting',
    //   'icon'              => 'edit',
    //   'keywords'          => array('記事', '投稿', 'タクソノミー', 'taxonomy', 'カテゴリー'),
    // ]);

    // acf_register_block_type([
    //   'name' => 'tab-container',
    //   'title' => 'タブブロック',
    //   'render_template' => get_template_directory() . '/acf/blocks/tabContainer.php',
    //   'mode' => 'preview',
    //   'supports' => [
    //     'jsx' => true,
    //     'align' => false,
    //     'innerBlocks' => true,
    //   ],
    //   'allowed_blocks' => [
    //     'acf/tab-panel', // タブコンテンツブロックだけを許可
    //   ],
    // ]);

    // acf_register_block_type([
    //   'name' => 'tab-panel',
    //   'title' => 'タブの中身',
    //   'render_template' => get_template_directory() . '/acf/blocks/tabPanel.php',
    //   'parent' => ['acf/tab-container'],
    //   'supports' => [
    //     'jsx' => true,
    //     'align' => false,
    //     'innerBlocks' => true,
    //   ],
    // ]);
    acf_register_block_type(array(
      'name'              => 'certificationslist',
      'title'             => '資格・検定 一覧',
      'description'       => '資格・検定 一覧ブロック',
      'render_template'   => get_template_directory() . '/acf/blocks/certificationslist.php',
      'category'          => 'formatting',
      'icon'              => 'edit',
      'keywords'          => array('certificationslist', '資格・検定', '一覧'),
    ));
  }
});

// ==========================================================================
// ギャラリーの余白を管理画面上で設定できるように（外観 > カスタマイズ）
// ==========================================================================
// カスタマイザーにPC用・スマホ用のギャラリー間隔設定を追加
function customize_gallery_settings($wp_customize)
{
  $wp_customize->add_section('gallery_settings', array(
    'title'    => 'ギャラリー設定',
    'priority' => 30,
  ));

  // スマホ用の間隔
  $wp_customize->add_setting('gallery_gap_mobile', array(
    'default'           => 16, // デフォルト値
    'sanitize_callback' => 'absint', // 数値のみ許可
  ));
  $wp_customize->add_control('gallery_gap_mobile', array(
    'label'   => '【SP用】画像間隔(px)',
    'section' => 'gallery_settings',
    'type'    => 'number',
  ));

  // PC用の間隔
  $wp_customize->add_setting('gallery_gap', array(
    'default'           => 40,
    'sanitize_callback' => 'absint',
  ));
  $wp_customize->add_control('gallery_gap', array(
    'label'   => '【PC用】画像間隔(px)',
    'section' => 'gallery_settings',
    'type'    => 'number',
  ));
}
add_action('customize_register', 'customize_gallery_settings');

// フロントに適用
function apply_gallery_custom_styles()
{
  $gallery_gap = get_theme_mod('gallery_gap', false);
  $gallery_gap_mobile = get_theme_mod('gallery_gap_mobile', false);
  $custom_css = "";

  if (is_numeric($gallery_gap_mobile)) {
    $custom_css .= "
      .wp-block-gallery {
        --gallery-block--gutter-size: {$gallery_gap_mobile}px !important;
      }
      ";
  }
  if (is_numeric($gallery_gap)) {
    $custom_css .= "
      @media (min-width: 768px) {
          .wp-block-gallery {
              --gallery-block--gutter-size: {$gallery_gap}px !important;
          }
        }
      ";
  }

  if (!empty($custom_css)) {
    wp_add_inline_style('wp-block-library', $custom_css);
  }
}
add_action('wp_enqueue_scripts', 'apply_gallery_custom_styles');

// Gutenbergエディタ（管理画面）に適用
function apply_editor_gallery_custom_styles()
{
  $gallery_gap = get_theme_mod('gallery_gap', false);
  $gallery_gap_mobile = get_theme_mod('gallery_gap_mobile', false);

  $custom_css = "";

  if (is_numeric($gallery_gap)) {
    $custom_css .= "
          .wp-block-gallery {
              --gallery-block--gutter-size: {$gallery_gap}px !important;
          }
      ";
  }

  if (is_numeric($gallery_gap_mobile)) {
    $custom_css .= "
          @media (max-width: 768px) {
              .wp-block-gallery {
                  --gallery-block--gutter-size: {$gallery_gap_mobile}px !important;
              }
          }
      ";
  }

  if (!empty($custom_css)) {
    wp_add_inline_style('wp-block-library', $custom_css);
  }
}
add_action('enqueue_block_editor_assets', 'apply_editor_gallery_custom_styles');

// ==========================================================================
// ギャラリーブロックで拡大画像をポップアップ表示させる
// https://hsmt-web.com/blog/gallery-block-fancybox/
// ==========================================================================
// ギャラリーブロックのHTMLをfancybox対応に書き換え
add_action("wp_enqueue_scripts", "gallery_funcybox_js");
function gallery_funcybox_js()
{
  if (is_singular()) {
    $data = <<<EOT
const parents = document.querySelectorAll(".wp-block-gallery");
for (let i = 0; i < parents.length; i++) {
	const children = parents[i].querySelectorAll("figure");

	for (let j = 0; j < children.length; j++) {
		children[j].children[0].setAttribute("data-fancybox", "gallery" + i );

		if( children[j].children[1] ){
			const figcaption = children[j].children[1].textContent;
			children[j].children[0].setAttribute("data-caption", figcaption);
		}
	}
}
EOT;
    wp_add_inline_script("fancybox", $data);
  }
}

// ギャラリーブロックの画像をすべて同じサイズにする(一覧表示の最終行を拡大しない)
add_action("wp_enqueue_scripts", "gallery_flex_grow");
add_action("admin_enqueue_scripts", "gallery_flex_grow");
function gallery_flex_grow()
{
  if (is_singular() || is_admin()) {
    $data = <<<EOT
.wp-block-gallery.has-nested-images figure.wp-block-image {
	flex-grow: 0;
}
EOT;
    wp_add_inline_style("wp-block-library", $data);
  }
}

// ==========================================================================
//	不要なブロックを非表示にする（ホワイトリスト形式）
//  https://www.will3in.co.jp/frontend-blog/article/hide-unwanted-blocks-in-gutenberg/
//  https://ja.wordpress.org/team/handbook/block-editor/reference-guides/core-blocks/
// ==========================================================================
function custom_allowed_block_types_all($allowed_block_types, $block_editor_context)
{
  $allowed = array(
    // ---------- テキスト ----------
    'core/paragraph',             // 段落
    'core/heading',               // 見出し
    'core/list',                  // リスト
    'core/list-item',             // リスト項目
    'core/quote',                 // 引用
    'core/freeform',              // クラシック
    'core/table',                 // テーブル
    // 'core/code',               // コード
    // 'core/details',            // 詳細
    // 'core/preformatted',       // 整形済みテキスト
    // 'core/pullquote',          // プルクオート
    // 'core/verse',              // 詩
    // 'core/footnotes',          // 脚注
    // 'core/missing',            // 非サポート

    // ---------- メディア ----------
    'core/image',                 // 画像
    'core/gallery',               // ギャラリー
    'core/video',                 // 動画
    // 'core/audio',              // 音声
    // 'core/file',               // ファイル

    // ---------- デザイン ----------
    'core/buttons',               // ボタンラッパー
    'core/button',                // ボタン
    'core/columns',               // カラム
    'core/column',                // カラム内
    'core/group',                 // グループ
    //'core/more',                // 続きを読む
    'core/nextpage',              // ページ区切り
    'core/separator',             // 区切り線
    'core/spacer',                // スペーサー
    // 'core/cover',              // カバーブロック
    'core/media-text',            // メディアと文章
    // 'core/page-break',         // 改ページ
    // 'core/site-logo',          // サイトロゴ
    // 'core/site-title',         // サイトタイトル
    // 'core/site-tagline',       // キャッチフレーズ
    // 'core/template-part',      // テンプレートパート

    // ---------- ウィジェット ----------
    'core/html',                  // カスタムHTML
    // 'core/shortcode',          // ショートコード
    // 'core/latest-posts',       // 最新の投稿

    // ---------- 埋め込み ----------
    'core/embed',                 // 埋め込み（すべてのプロバイダー）
    // 'core/twitter',            // Twitter埋め込み（廃止予定）
    // 'core/youtube',            // YouTube埋め込み
    // 'core/facebook',           // Facebook埋め込み

    // ---------- 同期パターン ----------
    'core/block',                 // 同期パターン（再利用ブロック）

    // ---------- サードパーティ ----------
    'flexible-table-block/table', // Flexible Table block

    // ---------- ACF ----------
    'acf/accordion',              // ACF アコーディオン
    'acf/button',                 // ACF ボタン
    // 'acf/in-page-link',           // ACF ページ内リンク
    // 'acf/navigation-large',       // ACF ナビゲーション（大）
    'acf/navigation-small',       // ACF ナビゲーション
    // 'acf/custom-post-list',       // ACF 投稿の出力
    // 'acf/tab-container',          // ACF タブコンテナ（親）
    // 'acf/tab-panel',              // ACF タブコンテンツ（子）
    // ※ タブボタンはACFフィールドで実装するためブロックとしては不要
    'acf/certificationslist',     // ACF 資格・検定 一覧
  );

  return $allowed;
}
add_filter('allowed_block_types_all', 'custom_allowed_block_types_all', 10, 2);

// ==========================================================================
// 埋め込みブロックでYouTubeのみを表示する
// ==========================================================================
add_action('admin_head', function () {
  echo '<style>
    /* 埋め込みプロバイダーの選択リストでYouTube以外を非表示 */
    .wp-block-embed .block-editor-block-variation-picker__variations li:not([aria-label*="YouTube"]) {
      display: none !important;
    }
    
    /* YouTubeだけは表示する */
    .wp-block-embed .block-editor-block-variation-picker__variations li[aria-label*="YouTube"] {
      display: block !important;
    }
    
    /* 一般的な埋め込みボタンは表示する */
    .block-editor-block-types-list__list-item:has(button.editor-block-list-item-embed:not([class*="/"])) {
      display: block !important;
    }

    /* 埋め込みリストのYouTube以外の項目を非表示 */
    .block-editor-block-types-list__list-item:has(button[class*="editor-block-list-item-embed/"]:not(.editor-block-list-item-embed\\/youtube)) {
      display: none !important;
    }
  </style>';
});

// ==========================================================================
// デフォルトパターンの非表示
// https://kmnmc.com/2023/02/24/6781/#google_vignette
// ==========================================================================
add_action('init', function () {
  remove_theme_support('core-block-patterns');
});
