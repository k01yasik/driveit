class MobileMenu {
  private smallNav: HTMLElement | null;
  private smallFirstLevel: HTMLElement | null;

  constructor() {
    this.smallNav = document.querySelector('.small-nav');
    this.smallFirstLevel = document.querySelector('.small-first-level');
    
    this.initEventListeners();
  }

  private initEventListeners(): void {
    // Menu icon click handler
    document.querySelector('.menu-icon-svg')?.addEventListener('click', () => {
      this.hideSmallNav();
      this.fadeInFirstLevel();
    });

    // Delete button click handler
    document.querySelector('.small-delete-button')?.addEventListener('click', () => {
      this.hideFirstLevel();
      this.fadeInSmallNav();
    });

    // Deleted item click handler
    document.querySelector('.small-deleted-item')?.addEventListener('click', () => {
      this.hideFirstLevel();
      this.fadeInSmallNav();
    });
  }

  private hideSmallNav(): void {
    if (this.smallNav) {
      this.smallNav.style.display = 'none';
    }
  }

  private fadeInFirstLevel(): void {
    if (this.smallFirstLevel) {
      this.smallFirstLevel.style.display = 'block';
      this.smallFirstLevel.style.opacity = '0';
      
      let opacity = 0;
      const fadeIn = () => {
        opacity += 0.05;
        if (this.smallFirstLevel) {
          this.smallFirstLevel.style.opacity = opacity.toString();
        }
        if (opacity < 1) {
          requestAnimationFrame(fadeIn);
        }
      };
      
      fadeIn();
    }
  }

  private hideFirstLevel(): void {
    if (this.smallFirstLevel) {
      this.smallFirstLevel.style.display = 'none';
    }
  }

  private fadeInSmallNav(): void {
    if (this.smallNav) {
      this.smallNav.style.display = 'block';
      this.smallNav.style.opacity = '0';
      
      let opacity = 0;
      const fadeIn = () => {
        opacity += 0.05;
        if (this.smallNav) {
          this.smallNav.style.opacity = opacity.toString();
        }
        if (opacity < 1) {
          requestAnimationFrame(fadeIn);
        }
      };
      
      fadeIn();
    }
  }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new MobileMenu();
});
