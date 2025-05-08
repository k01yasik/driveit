// Типы для TypeScript
interface ImageDeleteButton extends HTMLElement {
    dataset: {
        id: string;
        username: string;
        album: string;
        path: string;
        thumbnail: string;
    };
}

// Функция для удаления изображения
async function deleteImage(element: ImageDeleteButton): Promise<void> {
    const { id, username, album, path, thumbnail } = element.dataset;
    const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;

    if (!id || !username || !album || !path || !thumbnail || !csrfToken) {
        console.error('Missing required data attributes or CSRF token');
        return;
    }

    try {
        const params = new URLSearchParams();
        params.append('id', id);
        params.append('username', username);
        params.append('album', album);
        params.append('path', path);
        params.append('thumbnail', thumbnail);

        const response = await fetch(`/user/image/delete?${params.toString()}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (response.ok) {
            const result = await response.text();
            if (result === 'ok') {
                const parentElement = element.parentElement?.parentElement;
                if (parentElement) {
                    parentElement.remove();
                }
            }
        } else {
            console.error('Delete request failed:', response.status);
        }
    } catch (error) {
        console.error('Error deleting image:', error);
    }
}

// Инициализация обработчиков событий
function initImageDeleteButtons(): void {
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll<ImageDeleteButton>('.image-block-top-button');
        
        buttons.forEach(button => {
            button.addEventListener('click', () => deleteImage(button));
        });
    });
}

// Запуск инициализации
initImageDeleteButtons();
