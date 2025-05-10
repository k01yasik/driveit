class PostRating {
    private static init(): void {
        document.addEventListener('click', async (event) => {
            const target = event.target as HTMLElement;
            const ratingBlock = target.closest('.rating-block');
            
            if (ratingBlock) {
                event.preventDefault();
                await this.handleRatingClick(ratingBlock);
            }
        });
    }

    private static async handleRatingClick(ratingBlock: Element): Promise<void> {
        const postId = ratingBlock.getAttribute('data-id');
        const paragraph = ratingBlock.querySelector('p');

        if (!postId || !paragraph) return;

        try {
            const newRating = await this.submitRating(postId);
            paragraph.textContent = newRating;
        } catch (error) {
            console.error('Rating submission failed:', error);
            // Можно добавить уведомление пользователю
        }
    }

    private static async submitRating(postId: string): Promise<string> {
        const formData = new FormData();
        formData.append('id', postId);

        const response = await fetch('/rating/post', {
            method: 'POST',
            body: formData,
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.text();
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
    PostRating.init();
});
