'use strict';
// ==========================================================================
// OSやブラウザを判定してbodyにclassを付与
// ==========================================================================
const ua = navigator.userAgent.toLowerCase(),
  ver = navigator.appVersion.toLowerCase(),
  rootClass = document.documentElement.classList;
//ブラウザ判定
const isMSIE = ua.indexOf('msie') > -1 && ua.indexOf('opera') === -1, // IE(11以外)
  isIE6 = isMSIE && ver.indexOf('msie 6.') > -1, // IE6
  isIE7 = isMSIE && ver.indexOf('msie 7.') > -1, // IE7
  isIE8 = isMSIE && ver.indexOf('msie 8.') > -1, // IE8
  isIE9 = isMSIE && ver.indexOf('msie 9.') > -1, // IE9
  isIE10 = isMSIE && ver.indexOf('msie 10.') > -1, // IE10
  isIE11 = ua.indexOf('trident/7') > -1, // IE11
  isIE = isMSIE || isIE11, // IE
  isEdge = ua.indexOf('edge') > -1, // Edge
  isChrome = ua.indexOf('chrome') > -1 && ua.indexOf('edge') === -1, // Google Chrome
  isFirefox = ua.indexOf('firefox') > -1, // Firefox
  isSafari = ua.indexOf('safari') > -1 && ua.indexOf('chrome') === -1, // Safari
  isOpera = ua.indexOf('opera') > -1; // Opera
{
  //デバイス判定
  const _ua = (function (u) {
    return {
      Tablet:
        (u.indexOf('windows') !== -1 &&
          u.indexOf('touch') !== -1 &&
          u.indexOf('tablet pc') === -1) ||
        u.indexOf('ipad') !== -1 ||
        (u.indexOf('android') !== -1 && u.indexOf('mobile') === -1) ||
        (u.indexOf('firefox') !== -1 && u.indexOf('tablet') !== -1) ||
        u.indexOf('kindle') !== -1 ||
        u.indexOf('silk') !== -1 ||
        u.indexOf('playbook') !== -1,
      Mobile:
        (u.indexOf('windows') !== -1 && u.indexOf('phone') !== -1) ||
        u.indexOf('iphone') !== -1 ||
        u.indexOf('ipod') !== -1 ||
        (u.indexOf('android') !== -1 && u.indexOf('mobile') !== -1) ||
        (u.indexOf('firefox') !== -1 && u.indexOf('mobile') !== -1) ||
        u.indexOf('blackberry') !== -1,
    };
  })(window.navigator.userAgent.toLowerCase());

  if (_ua.Mobile) {
    rootClass.add('_device-mobile'); //スマホならつけるクラス
  } else if (_ua.Tablet) {
    rootClass.add('_device-tablet'); //タブレットならつけるクラス
  } else {
    rootClass.add('_device-pc'); //スマホ・タブレット以外ならつけるクラス
  }
  if (navigator.platform.indexOf('Win') !== -1) {
    rootClass.add('_os-win'); //Windowsならつけるクラス
  } else if (navigator.platform.toLowerCase().indexOf('mac') > -1) {
    rootClass.add('_os-mac'); //Windows以外ならつけるクラス
  }
  if (ua.indexOf('iPhone') > 0) {
    rootClass.add('_mobile-iphone'); //iPhoneならつけるクラス
  } else if (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
    rootClass.add('_mobile-android'); //Androidのスマホならつけるクラス
  } else if (ua.indexOf('iPad') > 0) {
    rootClass.add('_mobile-ipad'); //iPadならつけるクラス
  }
  if (isOpera) {
    rootClass.add('_browser-opera'); //オペラならつけるクラス
  } else if (isIE) {
    rootClass.add('_browser-ie'); //IEならつけるクラス
  } else if (isChrome) {
    rootClass.add('_browser-chrome'); //Chromeならつけるクラス
  } else if (isSafari) {
    rootClass.add('_browser-safari'); //Safariならつけるクラス
  } else if (isEdge) {
    rootClass.add('_browser-edge'); //Edgeならつけるクラス
  } else if (isFirefox) {
    rootClass.add('_browser-firefox'); //Firefoxならつけるクラス
  }
}

// ==========================================================================
// CSS遅延読み込み（class="async"をrel="stylesheet"に置換）
// ==========================================================================
{
  const webFonts = document.querySelectorAll('.async');
  for (let i = 0, l = webFonts.length; i < l; i++) {
    webFonts[i].rel = 'stylesheet';
  }
}

// ==========================================================================
//【CSS】カスタムプロパティvw https://www.6666666.jp/html/20220127/
// ==========================================================================
const setVw = function () {
  const vw = document.documentElement.clientWidth / 100;
  document.documentElement.style.setProperty('--vw', `${vw}px`);
};
window.addEventListener('DOMContentLoaded', setVw);
window.addEventListener('resize', setVw);

(function ($) {
  // ==========================================================================
  // ターゲットが特定位置を過ぎたらclass付与（ヘッダー追従）https://terkel.jp/archives/2011/05/jquery-floating-widget-plugin/
  // ==========================================================================
  $.fn.floatingWidget = function () {
    return this.each(function () {
      const $this = $(this),
        $parent = $this.offsetParent(),
        $body = $('body'),
        $window = $(window),
        top =
          $this.offset().top -
          parseFloat($this.css('marginTop').replace(/auto/, 0)),
        // bottom = $parent.offset().top + $parent.height() - $this.outerHeight(true),
        floatingClass = '_fixed';
      // pinnedBottomClass = '_bottom';
      if ($parent.height() > $this.outerHeight(true)) {
        $window.on('load scroll', function () {
          let y = $window.scrollTop();
          if (y > top) {
            $body.addClass(floatingClass);
          } else {
            $body.removeClass(floatingClass);
          }
        });
      }
    });
  };

  // ==========================================================================
  // グローバルナビゲーションカレント制御
  // ==========================================================================
  const globalNavCurrent = function () {
    const nav = $('#global_navigation'); // 第二階層をデフォルトで折りたたみ
    let condIndex =
      /(http[s]?:\/\/(?:[\w-_]+\.?){1,6}(?::\d+)?\/?)|\/[0-9]*\/[0-9]*\/[\w]*\.html?|\/[\w]*\.html?/; // index 除去条件
    let path = location.href.replace(condIndex, '/'); // URL
    const checks = [path];

    // 文字列末尾から 1 ディレクトリずつ削り、URL を収集
    while (path && '/' !== path) {
      path = path.replace(/[^/]*\/?$/, '');
      checks.push(path);
    }

    // メニューの href 属性値をすべて取得
    let href = $('a', nav).map(function () {
      return $(this).attr('href').replace(condIndex, '/');
    });

    // URL と href 属性値の一致を判定
    // 一致した a 要素には class 属性値「current」を付与
    checkStart: for (let i = 0; i < checks.length; i++) {
      for (let j = 0; j < href.length; j++) {
        if (checks[i] === href[j]) {
          $('a', nav)
            .eq(j)
            .addClass('_current')
            .parents('li')
            .addClass('_parent');
          break checkStart;
        }
      }
    }
  };

  // ==========================================================================
  // ローカルナビゲーションカレント制御
  // ==========================================================================
  const localNavCurrent = () => {
    const $nav = $('#local_navigation');

    // index.html などを除去するためのパターン
    const urlPattern =
      /(http[s]?:\/\/(?:[\w-_]+\.?){1,6}(?::\d+)?\/?)|\/[0-9]*\/[0-9]*\/[\w-]+\.(?:html?)?/;

    // URL文字列を正規化
    const normalize = (url) => {
      return (
        url
          .replace(urlPattern, '/') // ドメイン / index.html などを除去
          .replace(/\/$/, '') || '/'
      ); // 末尾 / を揃える
    };

    // 現在ページの階層リストを生成
    const getCurrentPathHierarchy = () => {
      let path = normalize(
        `${location.protocol}//${location.host}${location.pathname}`,
      );
      const hierarchy = [path];
      while (path && path !== '/') {
        path = path.replace(/[^/]*\/?$/, '').replace(/\/$/, '') || '/';
        hierarchy.push(path);
      }
      return hierarchy;
    };

    // ナビ内リンクを抽出して正規化
    const getNavLinks = () =>
      $('a', $nav)
        .toArray()
        .map((el) => {
          const $link = $(el);
          const raw = $link.attr('href') || '';
          if (!raw || raw.startsWith('#') || raw.startsWith('javascript:'))
            return null;
          return { element: $link, href: normalize(raw) };
        })
        .filter(Boolean); // null を除外

    // クラス付与
    const setCurrentState = ($el) => {
      $el
        .addClass('_current')
        .parents('li')
        .addClass('_parent')
        .closest('.lnl_wrapper')
        .css('display', 'block')
        .prevAll('button')
        .addClass('_open');
    };

    // メイン処理
    const hierarchy = getCurrentPathHierarchy();
    const links = getNavLinks();

    let best = null;
    let depth = 0;
    for (const { element, href } of links) {
      if (hierarchy.includes(href)) {
        const d = href.split('/').filter(Boolean).length;
        if (d > depth) {
          best = element;
          depth = d;
        }
      }
    }
    if (best) setCurrentState(best);
  };

  // ==========================================================================
  // スムーススクロール制御（ヘッダー分の高さは「const header = $('#global_header').height() * 2.5;」で調整）
  // ==========================================================================
  const pageScroll = function () {
    $(document).ready(function () {
      //URLのハッシュ値を取得
      const urlHash = location.hash;
      //ハッシュ値があればページ内スクロール
      if ('' !== urlHash) {
        //スクロールを0に戻しておく
        $('body,html').stop().scrollTop(1);
        setTimeout(function () {
          //ロード時の処理を待ち、時間差でスクロール実行
          scrollToAnker(urlHash);
        }, 300);
      }

      //通常のクリック時
      $('a[href^="#"]')
        .not(
          'ul[class*="tab-head"] a[href^="#"], .lnl_title , .frm_repeat_buttons a',
        )
        .on('click', function () {
          //ページ内リンク先を取得
          const href = $(this).attr('href');
          //リンク先が#か空だったらhtmlに
          const hash = href === '#' || href === '' ? 'html' : href;
          //スクロール実行
          scrollToAnker(hash);
          //リンク無効化
          return false;
        });

      // 関数：スムーススクロール
      // 指定したアンカー(#ID)へアニメーションでスクロール
      function scrollToAnker(hash) {
        const target = $(hash);
        const header = $('#global_header').innerHeight() + 30;
        const position = target.offset().top - header;
        $('body,html').stop().animate({ scrollTop: position }, 300);
      }
    });
  };

  // ==========================================================================
  // SP用メニュー＆PCメガメニュー設定
  // ==========================================================================
  const toggleMenu = function () {
    const $body = $('body');
    // グローバルナビゲーション
    $('#gh_menu').on('click', function () {
      $body.toggleClass('_open-menu _open-bg');
    });
    $('#gn_close').on('click', function () {
      $body.removeClass('_open-menu _open-bg');
    });
    $(
      '.module_menu-01 > li [class*="mm_button"], .gf_links-01 > li .gfl_button',
    ).on('click', function () {
      $(this).next().next().toggleClass('_open').slideToggle(400);
      $(this).toggleClass('_open');
    });

    //リサイズ時に不要なクラスを削除
    $(window).on('load resize', function () {
      $body.removeClass('_open-menu _open-bg _contentFixed');
    });

    // グローバルメニューの動き
    $('.global_navigation .gn_links-01 > li._hasChild').on({
      mouseenter: function () {
        const height = $(this).find('.gnl_inner').outerHeight(true);
        if ($('html').hasClass('_pc') || $('html').hasClass('_tablet')) {
          $body.addClass('_open-bg');
          $(this).find('.gnl_wrapper').first().css({
            height: 0,
            visibility: 'inherit',
            opacity: '1',
            'pointer-events': 'auto',
          });
          $(this)
            .find('.gnl_wrapper')
            .first()
            .stop(true, true)
            .animate({ height: height }, 400, 'swing');
        }
        //ここにはマウスを離したときの動作を記述
      },
      mouseleave: function () {
        if ($('html').hasClass('_pc') || $('html').hasClass('_tablet')) {
          $body.removeClass('_open-bg');
          $(this)
            .find('.gnl_wrapper')
            .animate({ height: 0 }, 400, 'swing')
            .queue(function () {
              $(this).removeAttr('style');
              $(this).dequeue();
            });
        }
      },
    });

    // 検索
    $('#search').on('click', function () {
      if ($body.hasClass('_open-bg')) {
        $body.addClass('_open-search');
      } else {
        if ($body.hasClass('_open-search')) {
          $body.removeClass('_open-search').removeClass('_open-bg');
        } else {
          $body.addClass('_open-search').addClass('_open-bg');
        }
      }
    });

    $('#gns_close, #overlay').on('click', function () {
      $body
        .removeClass('_open-search')
        .removeClass('_open-menu')
        .removeClass('_open-bg');
    });

    // アーカイブ用のローカルナビゲーションを開閉式にする
    $('body:not(.page) #local_navigation .ln_links-01 > li > .lnl_title').on(
      'click',
      function () {
        $(this).next().toggleClass('_open').slideToggle(400);
        $(this).toggleClass('_open');
        return false;
      },
    );
    // アーカイブナビゲーション
    $('.an_links-01 > li > .anl_title').on('click', function () {
      $(this).next().toggleClass('_open').slideToggle(400);
      $(this).toggleClass('_open');
    });
    // アーカイブナビゲーション枠外クリック時に閉じる
    $(document).on('touchstart click', function (event) {
      if (!$(event.target).closest('.an_links-01').length) {
        $('.an_links-01 > li > .anl_title')
          .removeClass('_open')
          .next('.anl_wrapper')
          .removeClass('_open')
          .slideUp(400)
          .find('.anl_button, .anl_wrapper')
          .removeClass('_open')
          .siblings('.anl_wrapper')
          .slideUp(400);
      } else {
      }
    });
    // ウィンドウ幅によってクラス付与
    $(window).on('load resize', function () {
      const w = $(window).width();
      if (w <= 768) {
        $('html').addClass('_sp').removeClass('_pc _tablet');
      } else if (w < 1024) {
        $('html').addClass('_tablet').removeClass('_pc _sp');
      } else {
        $('html').addClass('_pc').removeClass('_tablet _sp');
      }
    });
  };

  // ==========================================================================
  // Class付与
  // ==========================================================================
  const addCss = function () {
    // .global_contents内の新窓リンクにclass追加
    const notIcon = $(
      '[class*="module_card-"] a, .global_contents p a.icon-none, .top_banner-01 a',
    );
    $('.global_contents a:not([class])[target="_blank"]')
      .not(notIcon)
      .each(function () {
        $(this).addClass('icon-blank');
      });

    // エディタ内の表にclass追加
    $('.gc_main table:not([class])').each(function () {
      $(this).addClass('module_table-01');
    });

    // WordPressページネーションのclass付け替え
    $('ul.page-numbers')
      .addClass('module_pager-01')
      .removeClass('page-numbers');
    $('.module_pager-01 li.current')
      .prev('li')
      .addClass('current_prev')
      .prev('li')
      .addClass('current_prev2')
      .prev('li')
      .addClass('current_prev3')
      .prev('li')
      .addClass('current_prev4');
    $('.module_pager-01 li.current')
      .next('li')
      .addClass('current_next')
      .next('li')
      .addClass('current_next2')
      .next('li')
      .addClass('current_next3')
      .next('li')
      .addClass('current_next4');
  };

  // ==========================================================================
  // タグ追加・削除
  // ==========================================================================
  const initHTML = function () {
    // 空のpタグ削除
    $('.gc_main p').each(function () {
      let txt = $(this);
      if (txt.html().replace(/\s|&nbsp;/g, '').length === 0) {
        txt.remove();
      }
    });

    // 表にスクロール用ラッパー要素とclassを追加
    $('.module_table-01').wrap('<div class="module_table-wrap"></div>');
    $(window).on('load resize', function () {
      $('.module_table-wrap').each(function () {
        const $wrapperWidth = $(this).width();
        const $innerWidth = $(this).find('.module_table-01').width();
        if ($wrapperWidth < $innerWidth) {
          $(this).addClass('_scroll');
        } else {
          $(this).removeClass('_scroll');
        }
      });
    });

    // パスワード保護フォームinputにラッパー要素追加（疑似要素追加用）
    $('.module_password form input[type="submit"]').wrap(
      '<span class="mp_submit-wrap"><span class="mp_submit-inner"></span></span>',
    );
  };

  // ==========================================================================
  // モジュールモーダル設定 http://www.humaan.com/modaal/
  // ==========================================================================
  const moduleModal = function () {
    $('[class*="module_gallery"] a').modaal({
      type: 'image',
    });
  };

  // ==========================================================================
  // モジュールアコーディオン設定
  // ==========================================================================
  const moduleAccordion = function () {
    $('.module_accordion-01 > li').each(function () {
      const $list = $(this);
      const $button = $(this).find('.head');
      $list.find('.body').hide();
      $button.on('click', function () {
        if ($list.hasClass('_open')) {
          $list.removeClass('_open');
          $list.find('.body').slideUp(300);
        } else {
          // 項目を開いたときに他の項目を閉じる場合は下記を追加
          // $('.module_faqList-01 > li').removeClass('_open').find('.body').slideUp(300);
          $list.addClass('_open');
          $list.find('.body').slideDown(300);
        }
      });
    });
  };

  // ==========================================================================
  // メニューオープン時背景のスクロール禁止
  // ==========================================================================
  const contentFixed = function () {
    let state = false;
    let scrollpos;
    $('#gh_menu').on('click', function () {
      if (state == false) {
        scrollpos = $(window).scrollTop();
        $('body').addClass('_contentFixed');
        state = true;
      } else {
        $('body').removeClass('_contentFixed').css({ top: 0 });
        window.scrollTo(0, scrollpos);
        state = false;
      }
    });
    $('#gn_close').on('click', function () {
      $('body').removeClass('_contentFixed').css({ top: 0 });
      window.scrollTo(0, scrollpos);
      state = false;
    });
  };

  // ==========================================================================
  // pageTop
  // ==========================================================================
  const pageTop = function () {
    const gf_pageTop = $('#js_gf_pageTop');
    const windowWidth = $(window).width();
    gf_pageTop.hide();
    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 0) {
        gf_pageTop.fadeIn();
      } else {
        gf_pageTop.fadeOut();
      }
    });
  };

  // ==========================================================================
  // メニューオープン時文言変更
  // ==========================================================================
  // const menuTextChange = function () {
  //     let menuText = $("#menuButton").children(".menuText");
  //     $("#menuButton").on("click", function () {
  //         if ($("body").hasClass("_open-menu")) {
  //             menuText.text("CLOSE");
  //         } else {
  //             menuText.text("MENU");
  //         }
  //     });

  //     $(window).on("load resize", function () {
  //         menuText.text("MENU");
  //     });
  // };

  // ==========================================================================
  // .wp-lightbox-containerをラップ
  // ==========================================================================
  const lightboxWrap = function () {
    $('.block-editor_wrap figure.wp-lightbox-container img').each(function () {
      $(this).wrap('<div class="lightbox_wrap"></div>');
    });
  };

  // ==========================================================================
  // タブ
  // ==========================================================================
  const tab = function () {
    document.addEventListener('DOMContentLoaded', () => {
      document
        .querySelectorAll('.module_tab-wrapper')
        .forEach((tabWrapper, wrapperIndex) => {
          const panels = tabWrapper.querySelectorAll('.tab-panel');
          const buttonsContainer = tabWrapper.querySelector('.tab-buttons');

          panels.forEach((panel, index) => {
            // タイトルを取得（未指定なら Tab 1, 2...）
            const title = panel.dataset.title || `Tab ${index + 1}`;

            // ユニークIDを生成（日本語は slugify して短縮）
            const slug = title
              .toLowerCase()
              .normalize('NFKD') // 濁点など除去
              .replace(/[^\w\s-]/g, '') // 記号除去
              .trim()
              .replace(/\s+/g, '-') // 空白→ハイフン
              .slice(0, 20); // 長すぎるIDを防止

            const tabId = `tab-${wrapperIndex + 1}-${slug || index + 1}`;
            panel.id = tabId;

            // ボタン生成
            const button = document.createElement('button');
            button.className = 'tab-button';
            button.setAttribute('data-tab', tabId);
            button.setAttribute('type', 'button');
            button.innerText = title;

            button.addEventListener('click', () => {
              panels.forEach((p) => (p.style.display = 'none'));
              tabWrapper
                .querySelectorAll('.tab-button')
                .forEach((b) => b.classList.remove('active'));
              panel.style.display = '';
              button.classList.add('active');
            });

            buttonsContainer.appendChild(button);
          });

          // 初期状態：最初のパネルを表示
          if (panels.length > 0) {
            panels.forEach((p) => (p.style.display = 'none'));
            panels[0].style.display = '';
            const firstButton = buttonsContainer.querySelector('.tab-button');
            if (firstButton) firstButton.classList.add('active');
          }
        });
    });
  };

  // ==========================================================================
  // アーカイブナビゲーション
  // ==========================================================================
  const archiveNavigation = function () {
    $('#anl_button').on('click', function () {
      $(this).toggleClass('active');
      $(this).next('.anl_list').slideToggle(300);
    });
  };

  // ==========================================================================
  // table
  // スクロールヒント
  // ==========================================================================
  const scrollHint = function () {
    window.addEventListener('DOMContentLoaded', function () {
      $('.wp-block-flexible-table-block-table').addClass('js-scrollable');
      
      new ScrollHint('.js-scrollable', {
        //scrollHintIconAppendClass: 'scroll-hint-icon-green', // white-icon will appear
        remainingTime: -1, //5000
        i18n: {
          scrollable: 'スクロールできます',
        },
      });
    });
  };


  // ==========================================================================
  // 実行
  // ==========================================================================
  $('#global_header').floatingWidget();
  globalNavCurrent();
  localNavCurrent();
  pageScroll();
  toggleMenu();
  addCss();
  initHTML();
  moduleModal();
  moduleAccordion();
  contentFixed();
  pageTop();
  // menuTextChange();
  lightboxWrap();
  tab();
  archiveNavigation();
  scrollHint();
})(jQuery);
