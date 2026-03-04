document.addEventListener('DOMContentLoaded', function () {
  // gallery
  const gallerySection = {
    init() {
      try {
        this.cacheElements();
        this.initFancybox();
        this.observeScreenChange();
      } catch (error) {
        console.warn('PRODUCT GALLERY ERROR: ', error);
        return;
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector('.product-gallery .swiper');
      if (!this.swiperEl) {
        throw new Error('No swiper element found for product gallery');
      }
    },
    initSwiper() {
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
          nextEl: '.product-gallery .carousel-btn__next',
          prevEl: '.product-gallery .carousel-btn__prev',
        },
        pagination: {
          el: '.product-gallery .swiper-pagination',
          clickable: true,
        },
      });
    },
    initFancybox() {
      if (typeof Fancybox === 'undefined') {
        throw new Error('Fancybox is not loaded');
      }
      Fancybox.bind('[data-fancybox="hotel-gallery"]', {
        Thumbs: {
          type: 'classic',
        },
      });
    },
    observeScreenChange() {
      let swiperInitialized = false;
      const observer = new ResizeObserver(entries => {
        const entry = entries[0];
        if (entry.contentRect.width < 850) {
          if (!swiperInitialized) {
            this.initSwiper();
            swiperInitialized = true;
          }
        } else {
          if (this.swiper) {
            this.swiper.detachEvents();
            this.swiper.destroy(true, true);
            this.swiper = null;
            swiperInitialized = false;
            const slides = this.swiperEl.querySelectorAll('.swiper-slide');
            slides.forEach(slide => {
              slide.removeAttribute('style');
              slide.classList.remove('swiper-slide-active', 'swiper-slide-next', 'swiper-slide-prev');
            });
          }
        }
      });
      observer.observe(document.querySelector('.product-gallery'));
    },
  }.init();
  // product detail description
  const productDetailDescription = {
    init() {
      try {
        this.cacheElements();
        this.bindToggleEvent();
      } catch (error) {
        console.warn('PRODUCT DETAIL DESCRIPTION ERROR: ', error);
      }
    },
    cacheElements() {
      this.descriptionWrapperEl = document.querySelector('.product-detail__description-wrapper');
      if (!this.descriptionWrapperEl) {
        throw new Error('No description wrapper element found for product detail');
      }
      this.toggleButtonEl = this.descriptionWrapperEl.querySelector('.product-detail__description-toggle');
    },
    bindToggleEvent() {
      if (!this.toggleButtonEl) {
        throw new Error('No toggle button element found for product detail description');
      }
      this.toggleButtonEl.addEventListener('click', () => {
        const isExpanded = this.toggleButtonEl.getAttribute('aria-expanded') === 'true';
        this.toggleButtonEl.textContent = isExpanded ? 'Xem thêm' : 'Ẩn bớt';
        this.toggleButtonEl.setAttribute('aria-expanded', !isExpanded);
      });
    },
  }.init();
  // feedback carousel
  const feedbackCarousel = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch (error) {
        console.warn('FEEDBACK CAROUSEL ERROR: ', error);
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector('.product-detail__feedback-carousel .swiper');
      if (!this.swiperEl) {
        throw new Error('No swiper element found for feedback carousel');
      }
    },
    initSwiper() {
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
          nextEl: '.product-detail__feedback-carousel .carousel-btn__next',
          prevEl: '.product-detail__feedback-carousel .carousel-btn__prev',
        },
      });
    },
  }.init();
});
