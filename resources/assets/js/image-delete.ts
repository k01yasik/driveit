async function deleteImage(button: HTMLElement): Promise<void> {
    const { id, album } = button.dataset;
    const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
    if (!id || !album || !csrfToken || button.dataset.pending) return;

    button.dataset.pending = 'true';
    try {
        const params = new URLSearchParams({ id, album });
        const response = await fetch(`/user/image/delete?${params}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });

        if (!response.ok) {
            throw new Error(`Delete request failed: ${response.status}`);
        }

        const wrapper = button.closest('.image-wrapper');
        button.closest('.image-block')?.remove();
        if (wrapper && !wrapper.querySelector('.image-block')) {
            window.location.reload();
        }
    } catch (error) {
        console.error('Error deleting image:', error);
        delete button.dataset.pending;
    }
}

document.querySelector('.image-wrapper')?.addEventListener('click', (event) => {
    const button = (event.target as Element).closest<HTMLElement>('.image-block-top-button');
    if (button) {
        void deleteImage(button);
    }
});
