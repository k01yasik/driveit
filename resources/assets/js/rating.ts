class PostRating {
    private static pending = new Set<string>();

    public static init(): void {
        document.addEventListener('click', async (event) => {
            const button = (event.target as Element).closest<HTMLButtonElement>('button[data-rating-url]');
            if (button) await this.toggle(button);
        });
    }

    private static async toggle(button: HTMLButtonElement): Promise<void> {
        const { id, ratingUrl } = button.dataset;
        const token = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
        if (!id || !ratingUrl || !token || this.pending.has(id)) return;

        this.pending.add(id);
        button.disabled = true;
        try {
            const body = new FormData();
            body.append('id', id);
            const response = await fetch(ratingUrl, {
                method: 'POST',
                body,
                headers: { 'X-CSRF-TOKEN': token }
            });
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

            const count = await response.text();
            const voted = response.headers.get('X-Rating-Voted') === '1';
            document.querySelectorAll<HTMLButtonElement>('button[data-rating-url]').forEach((voteButton) => {
                if (voteButton.dataset.id !== id) return;
                voteButton.setAttribute('aria-pressed', String(voted));
                const countLabel = voteButton.querySelector('[data-rating-count]');
                if (countLabel) countLabel.textContent = count;
                voteButton.querySelector('[data-rating-status]')?.toggleAttribute('hidden', !voted);
            });

            if (document.querySelector('[data-rating-leaderboard]')) window.location.reload();
        } catch (error) {
            console.error('Rating submission failed:', error);
        } finally {
            this.pending.delete(id);
            button.disabled = false;
        }
    }
}

document.addEventListener('DOMContentLoaded', () => PostRating.init());
