const uploadInput: HTMLInputElement | null = document.getElementById(
  'upload_image_to_album_input',
) as HTMLInputElement;
const addImageButtons: NodeListOf<HTMLElement> = document.querySelectorAll('.add-image-button');
const imageProgress: HTMLProgressElement | null = document.querySelector('.image-progress');
const csrfTokenMeta: HTMLMetaElement | null = document.querySelector('meta[name="csrf-token"]');
const csrfToken: string = csrfTokenMeta?.content || '';

const handleButtonClick = (): void => {
  if (uploadInput) {
    uploadInput.click();
  }
};

const handleUploadError = (error: string): void => {
  console.error('Upload error:', error);
  
  if (imageProgress) {
    imageProgress.style.display = 'none';
    imageProgress.value = 0;
  }

  alert('Произошла ошибка при загрузке изображений. Пожалуйста, попробуйте снова.');
};

const initializeUploadHandlers = (): void => {
  addImageButtons.forEach((button: HTMLElement) => {
    button.addEventListener('click', handleButtonClick);
  });

  if (uploadInput) {
    uploadInput.addEventListener('change', async (event: Event) => {
      const target = event.target as HTMLInputElement;
      if (!target.files || target.files.length === 0) return;

      if (imageProgress) {
        imageProgress.style.display = 'block';
        imageProgress.value = 0;
      }

      const { name: albumName } = target.dataset;
      const formData = new FormData();

      Array.from(target.files).forEach((file) => {
        formData.append('images_upload[]', file);
      });

      if (albumName) formData.append('album_name', albumName);

      target.disabled = true;
      try {
        const response = await fetch('/user/albums/image/upload', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
          },
          body: formData,
        });

        if (!response.ok) {
          throw new Error(`Server returned status ${response.status}`);
        }

        window.location.reload();
      } catch (error) {
        const errorMessage = error instanceof Error ? error.message : 'Unknown error';
        handleUploadError(errorMessage);
        target.value = "";
        target.disabled = false;
      }
    });
  }
};

// Запуск приложения
initializeUploadHandlers();
