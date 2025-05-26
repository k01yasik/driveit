class UserUnbanHandler {
    public static init(): void {
        document.addEventListener('click', async (event) => {
            const target = event.target as HTMLElement;
            const button = target.closest('.unban-user-button') as HTMLElement | null;
            
            if (button) {
                event.preventDefault();
                await this.handleUnbanRequest(button);
            }
        });
    }

    private static async handleUnbanRequest(button: HTMLElement): Promise<void> {
        const userId = button.dataset.id;
        const message = button.dataset.message;

        if (!userId || !message) {
            console.error('Missing required data attributes');
            return;
        }

        try {
            const result = await this.sendUnbanRequest(userId);
            if (result === 'ok') {
                this.updateUI(button, message);
            }
        } catch (error) {
            console.error('Unban request failed:', error);
            // Add user notification here
        }
    }

    private static async sendUnbanRequest(userId: string): Promise<string> {
        const params = new URLSearchParams({ id: userId });
        const response = await fetch(`/admin/rips?${params}`, {
            method: 'DELETE',
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.text();
    }

    private static updateUI(button: HTMLElement, message: string): void {
        // Remove the unban button
        button.remove();

        // Add success message
        const userInfo = document.querySelector('.user-info');
        if (userInfo) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'button info-button right';
            messageDiv.textContent = message;
            userInfo.appendChild(messageDiv);
        }
    }

    private static getHeaders(): Headers {
        const headers = new Headers();
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (token) {
            headers.append('X-CSRF-TOKEN', token);
        }
        
        return headers;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    UserUnbanHandler.init();
});
