function debounce(func, delay) {
  let timeout;
  return function (...args) {
    const context = this;
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(context, args), delay);
  };
}
const videoController = {
  init() {
    try {
      this.cacheElements();
      this.initSettings();
      this.initObserver();
      this.bindEvents();
    } catch( error ) {
      console.warn('Video controller initialization failed:', error);
    }
  },
  initSettings() {
    this.countdown = 5;
    this.countdownTimeout = null;
    this.countdownInterval = null;
    this.autoplayCancelled = false;
  },
  cacheElements() {
    this.previewVideo = document.querySelector('.videos__preview > .video > video');
    if (!this.previewVideo) {
      throw new Error('Preview video element not found');
    }
    this.counterNumber = document.querySelector('.autoplay-counter__number');
    this.cancelBtn = document.querySelector('.autoplay-counter__cancel');  
    this.playBtn = document.querySelector('.videos__preview .material-symbols-outlined');
  },
  bindEvents() {
    this.cancelBtn.addEventListener('click', () => {
      this.autoplayCancelled = true;
      this.clearTimers();
      this.previewVideoObserver.unobserve(this.previewVideo);
      this.counterNumber.parentElement.classList.add('hidden');
    });
    this.playBtn.addEventListener('click', () => {
      this.autoplayCancelled = true;
      this.clearTimers();
      this.previewVideoObserver.unobserve(this.previewVideo);
      this.playVideo();
    });
  },
  clearTimers() {
    clearInterval(this.countdownInterval);
    clearTimeout(this.countdownTimeout);
  },
  playVideo() {
    if (!this.previewVideo.hasAttribute('controls')) {
      this.previewVideo.setAttribute('controls', '');
    }
    this.previewVideo.play();
    this.previewVideo.parentNode.classList.add('playing');
  },
  initObserver() {
    this.previewVideoObserver = new IntersectionObserver( entries => {
      const entry = entries[0];
      if (entry.isIntersecting) {
        if (!this.autoplayCancelled) {
          let timeLeft = this.countdown;
          this.counterNumber.textContent = timeLeft;
          this.countdownInterval = setInterval(() => {
            timeLeft--;
            this.counterNumber.textContent = timeLeft;
          }, 1000);
          this.countdownTimeout = setTimeout(() => {
            clearInterval(this.countdownInterval);
            this.playVideo();
            this.previewVideoObserver.unobserve(this.previewVideo);
          }, 1000 * this.countdown);
        } else {
          this.clearTimers();
        }
      } else {
        this.clearTimers();
      }
    }, { threshold: 0.5 } );
    this.previewVideoObserver.observe(this.previewVideo);
  }
};
export default videoController;