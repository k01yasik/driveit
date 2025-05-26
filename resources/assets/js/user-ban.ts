interface DeleteResponse {
    status: string;
    url: string;
}

class DeleteConfirmation {
    public static init(): void {
        document.addEventListener('click', async (event) => {
            const button = (event.target as HTMLElement).closest('.confirm-delete-button') as HTMLElement;
            if (button) {
                event.preventDefault();
                await this.handleDeleteConfirmation(button);
            }
        });
    }

    private static async handleDeleteConfirmation(button: HTMLElement): Promise<void> {
        const id = button.dataset.id;
        const message = button.dataset.message;
        const buttonText = button.dataset.button;

        if (!id || !message || !buttonText) {
            console.error('Missing required data attributes');
            return;
        }

        try {
            const result = await this.sendDeleteRequest(id);
            if (result.status === 'ok') {
                this.showSuccessMessage(message, buttonText, result.url);
            }
        } catch (error) {
            console.error('Delete failed:', error);
            // Add user notification here
        }
    }

    private static async sendDeleteRequest(id: string): Promise<DeleteResponse> {
        const formData = new FormData();
        formData.append('id', id);

        const response = await fetch('/admin/rips', {
            method: 'POST',
            body: formData,
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    private static showSuccessMessage(message: string, buttonText: string, url: string): void {
        const mainContent = document.querySelector('.main-content-wrapper');
        if (!mainContent) return;

        // Hide existing content
        const flexElements = mainContent.querySelectorAll('.flex');
        flexElements.forEach(el => el.classList.add('hidden'));

        // Create success message
        const successDiv = document.createElement('div');
        successDiv.className = 'flex flex-justify-space';
        successDiv.innerHTML = `
            <p class="lockout-message">${message}</p>
            <a href="${url}" class="button confirm-button">${buttonText}</a>
        `;

        mainContent.appendChild(successDiv);
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
    DeleteConfirmation.init();
});
