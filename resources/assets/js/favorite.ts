interface ImageElement extends HTMLElement {
    dataset: {
        id: string;
        username: string;
    };
}

async function addToFavorites(event: Event): Promise<void> {
    const button = event.target as ImageElement;
    if (!button?.dataset) return;

    const { id, username } = button.dataset;
    if (!id || !username) return;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('username', username);

    try {
        const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
        if (!csrfToken) throw new Error('CSRF token not found');

        const response = await fetch('/user/favorite/add', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const result = await response.text();
        const imageBlock = button.closest('.image-block-footer-button')?.previousElementSibling;
        if (imageBlock) {
            imageBlock.innerHTML = result;
        }
    } catch (error) {
        console.error('Error adding to favorites:', error);
        // Здесь можно добавить обработку ошибок, например, показать уведомление пользователю
    }
}

// Инициализация обработчиков событий
document.querySelectorAll('.image-wrapper').forEach(wrapper => {
    wrapper.addEventListener('click', (event) => {
        const target = event.target as HTMLElement;
        if (target.matches('.image-block-footer-button')) {
            addToFavorites(event);
        }
    });
});
