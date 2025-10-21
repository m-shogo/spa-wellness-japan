<?php if (is_home() || is_archive() || is_search() || (isset($params['pager']) && $params['pager'] === 'true')):?>
  <?php
  $pages = '';
  $range = 4;
  $showitems = ( $range * 2 ) + 1;

  global $paged;
  global $wp_query; // WordPress のメインクエリを取得
  
  // $posts_to_display が未定義の場合、$wp_query を使用
  $posts_to_display = isset($posts_to_display) ? $posts_to_display : $wp_query;
  
  if ( empty( $paged ) ) {
    $paged = 1;
  }

  //ページ情報の取得
  if ( $pages == '' ) {
    $pages = $posts_to_display->max_num_pages;
    if ( ! $pages ) {
      $pages = 1;
    }
  }

  if ( 1 != $pages ) {
    echo '<ul class="module_pager-01" role="menubar" aria-label="Pagination">';
    echo '<li class="prev"><a href="' . get_pagenum_link( $paged - 1 ) . '"><svg xmlns="http://www.w3.org/2000/svg" width="39" height="6" viewBox="0 0 39 6" fill="none"><path d="M0 3L5 0.113249V5.88675L0 3ZM39 3.5H4.5V2.5H39V3.5Z" fill="#515AAF"/></svg></a></li>';

//    if ( is_paged() ) {
//      //先頭へ
//      echo '<li class="prev"><a href="' . get_pagenum_link( 1 ) . '"><i class="fa-solid fa-arrow-left"></i></a></li>';
//      //1つ戻る
//      echo '<li class="prev"><a href="' . get_pagenum_link( $paged - 1 ) . '"><i class="fal fa-angle-left"></i></a></li>';
//    }
    //番号つきページ送りボタン
    for ( $i = 1; $i <= $pages; $i ++ ) {
      if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
        echo ( $paged == $i ) ? '<li class="current"><a class="current">' . $i . '</a></li>' : '<li><a href="' . get_pagenum_link( $i ) . '" class="inactive" >' . $i . '</a></li>';
      }
    }
    echo '<li class="next"><a href="' . get_pagenum_link( $paged + 1 ) . '"><svg xmlns="http://www.w3.org/2000/svg" width="39" height="6" viewBox="0 0 39 6" fill="none"><path d="M39 3L34 0.113249V5.88675L39 3ZM0 3.5H34.5V2.5H0V3.5Z" fill="#515AAF"/></svg></a></li>';
//    if ( $paged != $pages ) {
//      //1つ進む
//      //echo '<li class="next"><a href="' . get_pagenum_link( $paged + 1 ) . '"><i class="fal fa-angle-right"></i></a></li>';
//      //最後尾へ
//      echo '<li class="next"><a href="' . get_pagenum_link( $pages ) . '"><i class="fa-solid fa-arrow-right"></i></a></li>';
//    }
    echo '</ul>';
  }
  ?>
<?php endif; ?>