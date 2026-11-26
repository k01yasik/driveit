document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.querySelector<HTMLInputElement>('#post_upload_image_input');
    const imageInput = document.querySelector<HTMLInputElement>('#image');
    const uploadButton = document.querySelector('.post_upload_image_button');
    if (!fileInput || !imageInput || !uploadButton) return;

    const draftKey = 'title-post-image-url';
    const isNewPost = Boolean(document.querySelector('.submit-post-form'));
    const setImage = (url: string) => {
        let preview = document.querySelector<HTMLImageElement>('.uploaded-image');
        if (!preview) {
            preview = document.createElement('img');
            preview.className = 'uploaded-image';
            preview.alt = '';
            document.querySelector('.block-wrapper')?.after(preview);
        }
        preview.src = url;
        imageInput.value = url;
    };

    if (isNewPost && !imageInput.value) {
        const storedUrl = localStorage.getItem(draftKey);
        if (storedUrl) setImage(storedUrl);
    }

    uploadButton.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', async () => {
        const file = fileInput.files?.[0];
        const token = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
        if (!file || !token || fileInput.disabled) return;

        fileInput.disabled = true;
        try {
            const body = new FormData();
            body.append('post_upload', file);
            const response = await fetch('/admin/posts/image-upload', {
                method: 'POST',
                body,
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error(`Upload failed: ${response.status}`);

            const { url }: { url: string } = await response.json();
            setImage(url);
            if (isNewPost) localStorage.setItem(draftKey, url);
        } catch (error) {
            console.error('Image upload failed:', error);
        } finally {
            fileInput.disabled = false;
            fileInput.value = '';
        }
    });
});
