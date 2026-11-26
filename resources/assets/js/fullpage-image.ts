document.addEventListener('click', (event) => {
    const image = (event.target as Element).closest<HTMLImageElement>('.image-wrapper .image-block > img');
    if (!image || document.querySelector('.photo-preview')) return;

    const preview = document.createElement('dialog');
    preview.className = 'photo-preview';
    preview.setAttribute('aria-label', image.alt || 'Фото');

    const fullImage = document.createElement('img');
    fullImage.src = image.dataset.url || image.currentSrc || image.src;
    fullImage.alt = image.alt;

    const close = document.createElement('button');
    close.type = 'button';
    close.textContent = '×';
    close.setAttribute('aria-label', 'Закрыть фото');
    close.addEventListener('click', () => preview.close());
    preview.addEventListener('click', (click) => {
        if (click.target === preview) preview.close();
    });
    preview.addEventListener('close', () => preview.remove(), { once: true });

    preview.append(close, fullImage);
    document.body.append(preview);
    preview.showModal();
});
