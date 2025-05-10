class UserApiService {
  private static readonly API_ENDPOINT = '/api/user';

  public static init(): void {
    document.addEventListener('click', (event) => {
      const target = event.target as HTMLElement;
      if (target.closest('.test-airlock')) {
        event.preventDefault();
        this.fetchUserData();
      }
    });
  }

  private static async fetchUserData(): Promise<void> {
    try {
      const response = await fetch(this.API_ENDPOINT, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        credentials: 'include' // For sending cookies if needed
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      console.log(data.slug);
    } catch (error) {
      if (error instanceof Error) {
        if (error.message.includes('401')) {
          console.log('Unauthorized');
        } else {
          console.error('API request failed:', error);
        }
      }
    }
  }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  UserApiService.init();
});
