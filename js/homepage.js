document.addEventListener('DOMContentLoaded', function () {
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