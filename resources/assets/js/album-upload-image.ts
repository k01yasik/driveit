// Кэшируем элементы DOM
const uploadInput = document.getElementById('upload_image_to_album_input');
const addImageButtons = document.querySelectorAll('.add-image-button');
const imageProgress = document.querySelector('.image-progress');
const noImages = document.querySelector('.no-images');
const imageWrapper = document.querySelector('.image-wrapper');
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Обработчики клика по кнопкам добавления изображения
addImageButtons.forEach(button => {
  button.addEventListener('click', () => uploadInput.click());
});

// Обработчик изменения input файла
uploadInput.addEventListener('change', async function() {
  if (!this.files || this.files.length === 0) return;
  
  // Показываем прогресс-бар
  imageProgress.style.display = 'block';
  imageProgress.value = 0;
  
  const { name: albumName, username } = uploadInput.dataset;
  const formData = new FormData();
  
  // Добавляем файлы в FormData
  Array.from(this.files).forEach(file => {
    formData.append('images_upload[]', file);
  });
  
  formData.append('album_name', albumName);
  formData.append('username', username);
  
  try {
    const response = await fetch('/user/albums/image/upload', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      body: formData
    });

    if (!response.ok) {
      throw new Error(`Server returned status ${response.status}`);
    }

    const result = await response.json();
    handleUploadSuccess(result);
  } catch (error) {
    handleUploadError(error.message);
  }
});

// Обработчик прогресса загрузки (альтернатива для fetch)
function trackProgress(readableStream, progressCallback) {
  const reader = readableStream.getReader();
  let loaded = 0;
  
  return new ReadableStream({
    async start(controller) {
      while (true) {
        const { done, value } = await reader.read();
        if (done) break;
        
        loaded += value?.length || 0;
        progressCallback(loaded);
        controller.enqueue(value);
      }
      controller.close();
      reader.releaseLock();
    }
  });
}

// Обработчик успешной загрузки
function handleUploadSuccess(result) {
  // Скрываем сообщение "нет изображений"
  if (noImages) noImages.style.display = 'none';
  
  // Сбрасываем прогресс-бар
  imageProgress.style.display = 'none';
  imageProgress.value = 0;
  
  // Показываем обертку если скрыта
  if (imageWrapper.style.display === 'none') {
    imageWrapper.style.display = 'flex';
  }
  
  // Создаем HTML для новых изображений
  const imagesHtml = result.map(createImageHtml).join('');
  imageWrapper.insertAdjacentHTML('afterbegin', imagesHtml);
}

// Обработчик ошибки загрузки
function handleUploadError(error) {
  console.error('Upload error:', error);
  imageProgress.style.display = 'none';
  imageProgress.value = 0;
  alert('Произошла ошибка при загрузке изображений. Пожалуйста, попробуйте снова.');
}

// Функция для создания HTML одного изображения
function createImageHtml([, imageUrl, id, username, album]) {
  return `
  <div class="image-block">
    <div class="image-block-top">
      <div class="image-block-top-button" data-id="${id}" data-username="${username}" data-album="${album}">
        <svg version="1.1" class="image-block-button-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 94.926 94.926">
          <g>
            <path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0
            c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096
            c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476
            c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62
            s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path>
          </g>
        </svg>
      </div>
    </div>
    <img src="${imageUrl}" />
    <div class="image-block-footer">
      <div class="image-block-footer-counter">0</div>
      <div class="image-block-footer-wrapper">
        <div class="image-block-footer-button" data-id="${id}" data-username="${username}">
          <svg version="1.1" class="heart-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510">
            <g>
              <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55 
              C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"></path>
            </g>
          </svg>
        </div>
      </div>
    </div>
  </div>`;
}
