interface ImageUploadResult {
    url: string;
    path?: string;
}

class PostImageUploader {
    private static STORAGE_KEYS = {
        URL: 'title-post-image-url',
        PATH: 'title-post-image-path'
    };

    private static ELEMENTS = {
        blockWrapper: '.block-wrapper',
        uploadButton: '.post_upload_image_button',
        fileInput: '#post_upload_image_input',
        imageInput: '#image',
        uploadedImage: '.uploaded-image',
        csrfToken: 'meta[name="csrf-token"]'
    };

    public static init(): void {
        this.loadStoredImage();
        this.setupEventListeners();
    }

    private static loadStoredImage(): void {
        const imageUrl = localStorage.getItem(this.STORAGE_KEYS.URL);
        if (!imageUrl) return;

        this.createImageElement(imageUrl);
        document.querySelector<HTMLInputElement>(this.ELEMENTS.imageInput)!.value = imageUrl;
    }

    private static setupEventListeners(): void {
        document.querySelector(this.ELEMENTS.uploadButton)?.addEventListener('click', () => {
            document.querySelector<HTMLInputElement>(this.ELEMENTS.fileInput)?.click();
        });

        document.querySelector(this.ELEMENTS.fileInput)?.addEventListener('change', async () => {
            await this.handleImageUpload();
        });
    }

    private static async handleImageUpload(): Promise<void> {
        const fileInput = document.querySelector<HTMLInputElement>(this.ELEMENTS.fileInput);
        if (!fileInput?.files?.length) return;

        const currentUrl = document.querySelector<HTMLInputElement>(this.ELEMENTS.imageInput)?.value;
        const file = fileInput.files[0];

        try {
            if (currentUrl) {
                await this.deleteExistingImage(currentUrl);
            }
            await this.uploadNewImage(file);
        } catch (error) {
            console.error('Image upload failed:', error);
            // Здесь можно добавить уведомление пользователю об ошибке
        }
    }

    private static async deleteExistingImage(url: string): Promise<void> {
        const path = localStorage.getItem(this.STORAGE_KEYS.PATH);
        const params = new URLSearchParams({ url, path: path || '' });

        await fetch(`/admin/posts/image-destroy?${params}`, {
            method: 'DELETE',
            headers: this.getHeaders()
        });
    }

    private static async uploadNewImage(file: File): Promise<void> {
        const formData = new FormData();
        formData.append('post_upload', file);

        const response = await fetch('/admin/posts/image-upload', {
            method: 'POST',
            body: formData,
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`Upload failed with status ${response.status}`);
        }

        const result: ImageUploadResult = await response.json();

        this.clearExistingImage();
        this.createImageElement(result.url);
        this.updateFormAndStorage(result);
    }

    private static clearExistingImage(): void {
        document.querySelector(this.ELEMENTS.uploadedImage)?.remove();
    }

    private static createImageElement(url: string): void {
        const img = document.createElement('img');
        img.src = url;
        img.className = 'uploaded-image';
        document.querySelector(this.ELEMENTS.blockWrapper)?.after(img);
    }

    private static updateFormAndStorage(result: ImageUploadResult): void {
        const imageInput = document.querySelector<HTMLInputElement>(this.ELEMENTS.imageInput);
        if (imageInput) {
            imageInput.value = result.url;
        }

        localStorage.setItem(this.STORAGE_KEYS.URL, result.url);
        if (result.path) {
            localStorage.setItem(this.STORAGE_KEYS.PATH, result.path);
        }
    }

    private static getHeaders(): Headers {
        const headers = new Headers();
        const token = document.querySelector(this.ELEMENTS.csrfToken)?.getAttribute('content');
        if (token) {
            headers.append('X-CSRF-TOKEN', token);
        }
        return headers;
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    PostImageUploader.init();
});
