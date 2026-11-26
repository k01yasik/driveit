async function addToFavorites(button: HTMLElement): Promise<void> {
    const { id } = button.dataset;
    const token = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
    const counter = button.closest('.image-block-footer')?.querySelector('.image-block-footer-counter');
    if (!id || !token || !counter || button.dataset.pending) return;

    button.dataset.pending = 'true';
    try {
        const body = new FormData();
        body.append('id', id);

        const response = await fetch('/user/favorite/add', {
            method: 'POST',
            body,
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        });

        if (!response.ok) throw new Error(`Favorite request failed: ${response.status}`);
        const { count }: { count: number } = await response.json();
        counter.textContent = String(count);
    } catch (error) {
        console.error('Error adding to favorites:', error);
    } finally {
        delete button.dataset.pending;
    }
}

document.addEventListener('click', (event) => {
    const button = (event.target as Element).closest<HTMLElement>('.image-wrapper .image-block-footer-button');
    if (button) void addToFavorites(button);
});
