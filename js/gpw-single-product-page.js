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
  // amenities details toggle
  const amenitiesDetailsToggle = {
    init() {
      try {
        this.cacheElements();
        this.bindEvents();
      } catch (error) {
        console.warn('AMENITIES DETAILS TOGGLE ERROR: ', error);
      }
    },
    cacheElements() {
      this.openDialogBtnEl = document.querySelector('.product-detail__amenities .block__header-view-all');
      this.amenitiesDetailsDialogEl = document.querySelector('.amenities-details');
      if (!this.amenitiesDetailsDialogEl) {
        throw new Error('No amenities details dialog element found');
      }
      this.closeBtnEl = this.amenitiesDetailsDialogEl.querySelector('.amenities-details__close');
    },
    bindEvents() {
      if (!this.openDialogBtnEl || !this.closeBtnEl) {
        throw new Error('No toggle button elements found for amenities details');
      }
      this.openDialogBtnEl.addEventListener('click', () => {
        this.handleDialogToggle('open');
      });
      this.closeBtnEl.addEventListener('click', () => {
        this.handleDialogToggle('close');
      });
    },
    handleDialogToggle( state = 'open' ) {
      switch(state) {
        case 'open':
          this.amenitiesDetailsDialogEl.showModal();
          document.documentElement.classList.add('no-scroll');
          break;
        case 'close':
          this.amenitiesDetailsDialogEl.close();
          document.documentElement.classList.remove('no-scroll');
          break;
        default:
          console.warn('Unknown dialog state: ', state);
      }
    }
  }.init();
  // product detail description
  const productDescription = {
    init() {
      try {
        this.cacheElements();
        this.bindToggleEvent();
      } catch (error) {
        console.warn('PRODUCT DETAIL DESCRIPTION ERROR: ', error);
      }
    },
    cacheElements() {
      this.descriptionWrapperEl = document.querySelector('.product-description');
      if (!this.descriptionWrapperEl) {
        throw new Error('No description wrapper element found for product detail');
      }
      this.toggleButtonEl = this.descriptionWrapperEl.querySelector('.product-description__toggle');
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
        loop: true,
        autoplay: {
          delay: 3500,
        },
        grabCursor: true,
        pagination: {
          el: '.product-detail__feedback-carousel .swiper-pagination',
          clickable: true,
        }
      });
    },
  }.init();
  // related products carousel
  const relatedProductsCarousel = {
    init() {
      try {
        this.cacheElements();
        this.initSwiper();
      } catch (error) {
        console.warn('RELATED PRODUCTS CAROUSEL ERROR: ', error);
      }
    },
    cacheElements() {
      this.swiperEl = document.querySelector('.related-products .swiper');
      if (!this.swiperEl) {
        throw new Error('No swiper element found for related products carousel');
      }
    },
    initSwiper() {
      if(typeof Swiper === 'undefined') {
        throw new Error('Swiper is not loaded');
      }
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: {
          550: {
            slidesPerView: 2,
          },
          850: {
            slidesPerView: 4,
          },
        },
        navigation: {
          nextEl: '.related-products .carousel-btn__next',
          prevEl: '.related-products .carousel-btn__prev',
        },
      });
    },
  }.init();
});