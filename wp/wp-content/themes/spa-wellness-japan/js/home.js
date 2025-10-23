"use strict";
(function ($) {
  // ==========================================================================
  // トップスライダー設定
  // ==========================================================================
  const topSlider = function () {
    $(window).on('load', function () {
      const tm_swiper = new Swiper('.tm_swiper-container', {
        effect: 'fade',
        loop: true,
        speed: 1000,
        watchOverflow: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        }
      })
    });
  };
  // const newsSlider = function () {
  //   $(window).on('load', function () {
  //     const news_swiper = new Swiper('.news_swiper-container', {
  //       slidesPerView: 4,
  //       spaceBetween: 40,
  //       loop: true,
  //       speed: 1000,
  //       watchOverflow: true,
  //       navigation: {
  //         nextEl: '.swiper-button-next',
  //         prevEl: '.swiper-button-prev',
  //       },
  //       breakpoints: {
  //         1000: {
  //           slidesPerView: 1.2,
  //           spaceBetween: 25,
  //           centeredSlides : true
  //         },
  //       },
  //     });
  //   });
  // };
    const listSlider = function () {
    //https://piaenglish.co.jp/ieltstrainerpro/
    $(window).on('load', function () {
      const contentsClass = 'list';
      const contentsClassWrap = `.top_certification-01`;
      const sliderSelector = `${contentsClassWrap} .${contentsClass}_swiper-container`; // スライダーのコンテナーとなる要素のセレクタ
      const slidesPerView_SP = 1; // スライド表示数
      const slidesPerView_PC = 3; // スライド表示数
      const $slide = $(sliderSelector + ' .swiper-slide');
      const slidable_SP = $slide.length > slidesPerView_SP;
      const slidable_PC = $slide.length > slidesPerView_PC;
      const containerModifierClass_SP =  slidable_SP ? 'swiper-container-' : '_none-'; // スライドがアクティブな場合は、コンテナー要素にクラス名「is-active」を設定
      const containerModifierClass_PC =  slidable_PC ? 'swiper-container-' : '_none-'; // スライドがアクティブな場合は、コンテナー要素にクラス名「is-active」を設定
      let slides_SpaceBetween_SP;
      let slides_SpaceBetween_PC;
      let slides_centered;
      if($slide.length === 1) {
        slides_SpaceBetween_SP = 0;
        slides_SpaceBetween_PC = 0;
      } else {
        slides_SpaceBetween_SP = 20;
        slides_SpaceBetween_PC = 20;
      }
      const list_swiper = new Swiper(sliderSelector, {
        speed: 1000,
        watchOverflow: true,
        slidesPerView: 'auto',
        containerModifierClass: containerModifierClass_SP,
        spaceBetween: slides_SpaceBetween_SP,
        centeredSlides : true,
        loop: slidable_SP,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false
        },
        breakpoints: { // ブレークポイント
          1000: {
            slidesPerView: 'auto',
            containerModifierClass: containerModifierClass_PC,
            spaceBetween: slides_SpaceBetween_PC,
            centeredSlides : true,
            loop: slidable_PC,
            pagination: {
              el: slidable_PC ? `${contentsClassWrap} .swiper-pagination` : null,
              clickable: true
            },
            navigation: {
              nextEl: slidable_PC ? `${contentsClassWrap} .swiper-button-next` : null,
              prevEl: slidable_PC ? `${contentsClassWrap} .swiper-button-prev` : null,
            }
          },
        },
        pagination: {
          el: slidable_SP ? `${contentsClassWrap} .swiper-pagination` : null,
          clickable: true
        },
        navigation: {
          nextEl: slidable_SP ? `${contentsClassWrap} .swiper-button-next` : null,
          prevEl: slidable_SP ? `${contentsClassWrap} .swiper-button-prev` : null,
        }
      })
    });
  };

  const tab = function () {
    $(window).on('load', function () {
      // 指定されたidのタブだけ表示し、他は非表示にする
      function toggleTab($root, id) {
        const $bodies = $root.find('.module_tab-body');
        // すべて非表示にする（inline styleで display:none を付与）
        $bodies.css('display', 'none');

        // idが有効ならその要素を表示、無効なら先頭を表示（安全策）
        const $target = id ? $bodies.filter('#' + id) : $();
        if ($target.length) {
          // 指定タブのみ表示（inline styleで display:block を付与）
          $target.css('display', 'block');
        } else {
          // 一致するidが見つからない場合は最初のタブを表示
          $bodies.first().css('display', 'block');
        }
      }

      // 初期化：ページ読込時に現在の選択値で表示を揃える
      $('.module_tab-02').each(function() {
        const $root = $(this);
        const $select = $root.find('.module_select-02 select');
        const selected = $select.val(); // プレースホルダーだと空文字の可能性あり
        toggleTab($root, selected);
      });

      // 変更イベント：選択が変わったら表示を切り替える
      $(document).on('change', '.module_select-02 select', function() {
        const $root = $(this).closest('.module_tab-02');
        const val = $(this).val();
        toggleTab($root, val);
      });
    });
  }

  // ==========================================================================
  // 実行
  // ==========================================================================
  topSlider();
  //newsSlider();
  listSlider();
  tab();

})(jQuery);
