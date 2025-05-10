class AvatarUploader {
  private static readonly AVATAR_SIZE = { width: 200, height: 200 };

  public static init(): void {
    // Trigger file input when button is clicked
    document.querySelector('.upload-button')?.addEventListener('click', () => {
      document.getElementById('change-avatar-input')?.click();
    });

    // Handle file selection
    document.getElementById('change-avatar-input')?.addEventListener('change', (event) => {
      const input = event.target as HTMLInputElement;
      if (input.files?.length) {
        this.handleFileUpload(input.files[0], input.dataset.username || '');
      }
    });
  }

  private static async handleFileUpload(file: File, username: string): Promise<void> {
    try {
      // Create FormData and add basic fields
      const formData = new FormData();
      formData.append('avatar_upload', file);
      formData.append('username', username);

      // Get image dimensions and perform smart cropping
      const cropData = await this.getCropData(file);
      Object.entries(cropData).forEach(([key, value]) => {
        formData.append(key, value.toString());
      });

      // Upload the cropped image
      const result = await this.uploadAvatar(formData);
      this.updateAvatarImage(result);
    } catch (error) {
      console.error('Avatar upload failed:', error);
      // Add user notification here
    }
  }

  private static async getCropData(file: File): Promise<{ x: number; y: number; width: number; height: number }> {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.src = URL.createObjectURL(file);

      img.onload = () => {
        URL.revokeObjectURL(img.src);
        console.log('Original dimensions:', img.width, img.height);

        smartcrop.crop(img, this.AVATAR_SIZE)
          .then(result => {
            console.log('Crop dimensions:', result.topCrop);
            resolve({
              x: result.topCrop.x,
              y: result.topCrop.y,
              width: result.topCrop.width,
              height: result.topCrop.height
            });
          })
          .catch(reject);
      };

      img.onerror = () => reject(new Error('Failed to load image'));
    });
  }

  private static async uploadAvatar(formData: FormData): Promise<string> {
    const response = await fetch('/user/avatar/upload', {
      method: 'POST',
      body: formData,
      headers: this.getHeaders()
    });

    if (!response.ok) {
      throw new Error(`Upload failed with status ${response.status}`);
    }

    return await response.text();
  }

  private static updateAvatarImage(newSrc: string): void {
    const avatarImg = document.querySelector('.avatar-inner img') as HTMLImageElement;
    if (avatarImg) {
      avatarImg.src = newSrc;
    }
  }

  private static getHeaders(): Headers {
    const headers = new Headers();
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
      headers.append('X-CSRF-TOKEN', token);
    }
    return headers;
  }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  AvatarUploader.init();
});
