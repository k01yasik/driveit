const SCROLL_SHOW_HEIGHT: number = 500;
const SCROLL_DURATION_MULTIPLIER: number = 0.5;
const MIN_SCROLL_DURATION: number = 800;
const MAX_SCROLL_DURATION: number = 1000;

interface ScrollOptions {
  duration: number;
  easing: (progress: number) => number;
}

class BackToTop {
  private backButton: HTMLElement;
  private scrollFrameId: number | null = null;
  private animationFrameId: number | null = null;

  constructor(selector: string) {
    const element = document.querySelector(selector);
    if (!element) throw new Error(`Element ${selector} not found`);
    
    this.backButton = element as HTMLElement;
    this.init();
  }

  private init(): void {
    this.backButton.addEventListener('click', (e) => this.scrollToTop(e));
    window.addEventListener('scroll', () => this.handleScroll());
  }

  private handleScroll(): void {
    if (this.scrollFrameId) {
      cancelAnimationFrame(this.scrollFrameId);
    }

    this.scrollFrameId = requestAnimationFrame(() => {
      const isVisible = window.scrollY > SCROLL_SHOW_HEIGHT;
      this.backButton.classList.toggle('back-to-top--visible', isVisible);
    });
  }

  private scrollToTop(e: Event): void {
    e.preventDefault();
    
    const startPosition: number = window.scrollY;
    const duration: number = Math.min(
      MAX_SCROLL_DURATION,
      Math.max(
        MIN_SCROLL_DURATION,
        startPosition * SCROLL_DURATION_MULTIPLIER
      )
    );

    const startTime: number = performance.now();
    const options: ScrollOptions = {
      duration,
      easing: this.easeOutQuad
    };

    const animateScroll = (currentTime: number): void => {
      const elapsedTime: number = currentTime - startTime;
      const progress: number = Math.min(elapsedTime / options.duration, 1);
      const ease: number = options.easing(progress);

      window.scrollTo(0, startPosition * (1 - ease));

      if (progress < 1) {
        this.animationFrameId = requestAnimationFrame(animateScroll);
      } else {
        this.animationFrameId = null;
      }
    };

    this.animationFrameId = requestAnimationFrame(animateScroll);
  }

  private easeOutQuad(progress: number): number {
    return progress < 0.5 
      ? 2 * progress * progress 
      : 1 - Math.pow(-2 * progress + 2, 2) / 2;
  }

  public destroy(): void {
    if (this.scrollFrameId) cancelAnimationFrame(this.scrollFrameId);
    if (this.animationFrameId) cancelAnimationFrame(this.animationFrameId);
    
    this.backButton.removeEventListener('click', this.scrollToTop);
    window.removeEventListener('scroll', this.handleScroll);
  }
}

// Инициализация
const backToTop = new BackToTop('.back-to-top');

// Для отключения (если нужно)
// backToTop.destroy();
