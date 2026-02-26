document.addEventListener('DOMContentLoaded', function () {
  // hero section controls
  const heroCtrl = {
    init() {
      try {
        this.cacheElements();
        this.initState();
        this.observeSectionSize();
        this.bindEvents();
      } catch( error ) {
        console.warn('HERO SECTION ERROR: ', error);
      }
    },
    initState() {
      this.state = new Proxy({
        currentWindow: null,
      }, {
        set: (target, prop, value) => {
          target[prop] = value;
          return true;
        }
      });
    },
    cacheElements() {
      this.heroSection = document.querySelector('.hero');
      if( !this.heroSection) {
        throw new Error('Hero section not found');
      }
      this.formWrapper = this.heroSection.querySelector('.hero__form-wrapper');
      this.navItems = [...this.heroSection.querySelectorAll('.tabs-nav__item[aria-controls]')];
      this.tabPanels = [...this.heroSection.querySelectorAll('.tabs__panel')].reduce( (acc, panel) => {
        const id = panel.getAttribute('id');
        if( id ) {
          acc[id] = panel;
        }
        return acc;
      }, {});
      this.closePopupBtn = this.heroSection.querySelector('.hero__close-btn');
    },
    bindEvents() {
      if( this.navItems.length === 0 ) {
        throw new Error('No navigation items found in hero section');
      }
      this.navItems.forEach( item => {
        item.addEventListener('click', event => this.handleNavItemClick(event, item));
      });
      if( this.closePopupBtn ) {
        this.closePopupBtn.addEventListener('click', event => this.handleNavItemClick(event, this.closePopupBtn));
      }
    },
    handleNavItemClick(event, item) {
      const panelId = item.getAttribute('aria-controls');
      console.log('Clicked nav item for panel: ', panelId);
      if( this.state.currentWindow === 'mobile' ) {
        this.formWrapper.classList.toggle('active');
        document.documentElement.classList.toggle('no-scroll', this.formWrapper.classList.contains('active'));
      } else {
        if( panelId && this.tabPanels[panelId] ) {
          // swap to active tab panel
        }
      }
    },
    observeSectionSize() {
      const resizeObserver = new ResizeObserver(entries => {
        const entry = entries[0];
        if (entry.contentRect.width < 850) {
          this.state.currentWindow = 'mobile';
        } else {
          this.state.currentWindow = 'desktop';
        }
      });
      resizeObserver.observe(this.heroSection);
    }
  }.init();
  // hotel carousel
  const hotelCarousel = {
    init() {
      try {
        this.cacheElements();
        this.initCarousel();
      } catch( error ) {
        console.warn('Hotel carousel error: ', error);
      }
    },
    cacheElements() {
      this.carousel = document.querySelector('.hotel-carousel .swiper');
      if( !this.carousel ) {
        throw new Error('Hotel carousel element not found');
      }
    },
    initCarousel() {
      if( typeof Swiper === 'undefined' ) {
        throw new Error('Swiper library not loaded');
      }
      this.swiper = new Swiper(this.carousel, {
        slidesPerView: 1.5,
        spaceBetween: 20,
        breakpoints: {
          550: {
            slidesPerView: 2,
          },
          850: {
            slidesPerView: 4,
          }
        },
        navigation: {
          nextEl: '.hotel-carousel__next',
          prevEl: '.hotel-carousel__prev',
        }
      });
    }
  }.init();
  // category carousel swiper
  const categoryCarousel = new Swiper('.category-carousel__posts', {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    breakpoints: {
      550: {
        slidesPerView: 3,
      },
      850: {
        slidesPerView: 4,
      },
    },
    navigation: {
      nextEl: '.category-carousel__next',
      prevEl: '.category-carousel__prev',
    },
  });

  // Magazine carousel swiper
  const magazineCarousel = new Swiper('.magazines__posts.swiper', {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    breakpoints: {
      550: {
        slidesPerView: 3,
      },
      850: {
        slidesPerView: 4,
      },
    },
    navigation: {
      nextEl: '.magazines__next',
      prevEl: '.magazines__prev',
    },
  });

  // Video player play when scroll into view
  function debounce(func, delay) {
    let timeout;
    return function (...args) {
      const context = this;
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), delay);
    };
  }
  const previewVideo = document.querySelector('.videos__preview > .video > video');
  const counterNumber = document.querySelector('.autoplay-counter__number');
  const cancelBtn = document.querySelector('.autoplay-counter__cancel');
  let countdown = 5;
  let countdownTimeout;
  let countdownInterval;
  const clearTimers = () => {
    clearInterval(countdownInterval);
    clearTimeout(countdownTimeout);
  };
  let autoplayCancelled = false;
  const playVideo = () => {
    if (!previewVideo.hasAttribute('controls')) {
      previewVideo.setAttribute('controls', '');
    }
    previewVideo.play();
    previewVideo.parentNode.classList.add('playing');
  };
  const debouncedPlayVideo = debounce(() => {
    playVideo();
    // remove observer after video played
    previewVideoObserver.unobserve(previewVideo);
  }, 1000 * countdown);
  /**
   * Intersection observer for preview video.
   *
   * @type {IntersectionObserver}
   */
  const previewVideoObserver = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          if(!autoplayCancelled){
            let timeLeft = countdown;
            counterNumber.textContent = timeLeft;
            countdownInterval = setInterval(() => {
              timeLeft--;
              counterNumber.textContent = timeLeft;
            }, 1000);
            countdownTimeout = setTimeout(() => {
              clearInterval(countdownInterval);
              playVideo();
              previewVideoObserver.unobserve(previewVideo);
            }, 1000 * countdown);
          } else {
            clearTimers();
          }
        } else {
          clearTimers();
        }
      });
    },
    {
      threshold: 0.5,
    }
  );
  previewVideoObserver.observe(previewVideo);

  cancelBtn.addEventListener('click', () => {
    autoplayCancelled = true;
    clearTimers();
    previewVideoObserver.unobserve(previewVideo);
    counterNumber.parentElement.classList.add('hidden');
  });

  // Video player play when click on play button
  const playBtn = document.querySelector('.videos__preview .material-symbols-outlined');
  playBtn.addEventListener('click', playVideo);
});