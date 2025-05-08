// Типы для TypeScript
type ImageBlockElement = HTMLElement & {
    querySelector(selectors: 'img'): HTMLImageElement | null;
};

// Основная функция для отображения полноразмерного изображения
function showFullImage(url: string): void {
    const mainElement = document.querySelector('main');
    if (!mainElement) return;

    const fullpageBlock = document.createElement('div');
    fullpageBlock.className = 'fullpage-block';

    const img = document.createElement('img');
    img.className = 'fullpage-image';
    img.src = url;
    img.alt = 'Full size image';

    const messagesDiv = document.createElement('div');
    messagesDiv.className = 'fullpage-messages';

    fullpageBlock.append(img, messagesDiv);
    mainElement.appendChild(fullpageBlock);
}

// Инициализация обработчиков событий
function initImageBlocks(): void {
    document.addEventListener('DOMContentLoaded', () => {
        const imageBlocks = document.querySelectorAll('.image-block');
        
        imageBlocks.forEach(block => {
            block.addEventListener('click', (event) => {
                const imgElement = (block as ImageBlockElement).querySelector('img');
                if (!imgElement) return;
                
                const imageUrl = imgElement.dataset.url;
                if (imageUrl) {
                    showFullImage(imageUrl);
                }
            });
        });
    });
}

// Запуск инициализации
initImageBlocks();
