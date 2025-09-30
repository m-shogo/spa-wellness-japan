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

  // ==========================================================================
  // 実行
  // ==========================================================================
  topSlider();
  //newsSlider();

})(jQuery);
