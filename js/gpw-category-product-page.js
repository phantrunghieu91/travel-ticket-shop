document.addEventListener('DOMContentLoaded', function () {
  const productsCarousels = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch( error ) {
        console.warn('Error initializing product carousels:', error);
      }
    },
    cacheElements() {
      this.swiperEls = document.querySelectorAll('.gpw-products__carousel');
      console.log(this.swiperEls);
      if( this.swiperEls.length === 0 ) {
        throw new Error('No product carousels found');
      }
    },
    initSwiper() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper library is not loaded');
      }
      this.swiperEls.forEach(swiperEl => {
        new Swiper(swiperEl.querySelector('.swiper'), {
          slidesPerView: 1,
          spaceBetween: 20,
          navigation: {
            nextEl: swiperEl.querySelector('.carousel-btn__next'),
            prevEl: swiperEl.querySelector('.carousel-btn__prev'),
          },
          breakpoints: {
            550: {
              slidesPerView: 2,
            },
            850: {
              slidesPerView: 4,
            }
          },
          scrollbar: {
            el: swiperEl.querySelector('.swiper-scrollbar'),
            draggable: true,
          },
        });
      });
    }
  }.init();
});