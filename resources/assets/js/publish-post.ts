class PostPublisher {
    private static PUBLISH_ICON = `
        <svg version="1.1" class="publish-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" enable-background="new 0 0 26 26">
            <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"/>
        </svg>
    `;

    private static UNPUBLISH_ICON = `
        <svg version="1.1" class="unpublish-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381" xml:space="preserve">
            <g>
                <path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"/>
            </g>
        </svg>
    `;

    public static init(): void {
        document.addEventListener('click', (event) => {
            const target = event.target as HTMLElement;
            const button = target.closest('.publish');
            
            if (button) {
                event.preventDefault();
                this.handlePublishClick(button);
            }
        });
    }

    private static async handlePublishClick(button: HTMLElement): Promise<void> {
        const postId = button.dataset.id;
        
        try {
            await this.togglePublishStatus(postId);
            this.toggleButtonIcon(button);
        } catch (error) {
            console.error('Failed to toggle publish status:', error);
            // Можно добавить уведомление пользователю
        }
    }

    private static async togglePublishStatus(postId: string): Promise<void> {
        const formData = new URLSearchParams();
        formData.append('id', postId);

        const response = await fetch('/admin/posts/publish', {
            method: 'PUT',
            body: formData,
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
    }

    private static toggleButtonIcon(button: HTMLElement): void {
        const isPublished = button.querySelector('.unpublish-svg');
        button.innerHTML = isPublished ? this.PUBLISH_ICON : this.UNPUBLISH_ICON;
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

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    PostPublisher.init();
});
