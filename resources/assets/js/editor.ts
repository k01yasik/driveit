interface EditorCommand {
  command: string;
  value?: string | null;
}

class TextEditor {
  private editor: HTMLElement;
  private selectItemSub: HTMLElement;
  private imageSelectItemSub: HTMLElement;
  private selectItemInput: HTMLInputElement;
  private imageSelectItemInput: HTMLInputElement;
  private imageItem: HTMLElement;
  private uploadImage: HTMLInputElement;
  private bodyInput: HTMLInputElement | HTMLTextAreaElement | null;
  private savedRange: Range | null = null;

  constructor() {
    this.editor = this.getElement('.text-editor-body');
    this.selectItemSub = this.getElement('.select-item-sub');
    this.imageSelectItemSub = this.getElement('.image-select-item-sub');
    this.selectItemInput = this.getElement('.select-item-input') as HTMLInputElement;
    this.imageSelectItemInput = this.getElement('.image-select-item-input') as HTMLInputElement;
    this.imageItem = this.getElement('.image-item');
    this.uploadImage = this.getElement('#upload_image_form_input') as HTMLInputElement;
    this.bodyInput = document.querySelector<HTMLInputElement | HTMLTextAreaElement>('#body');

    this.init();
  }

  private getElement(selector: string): HTMLElement {
    const element = document.querySelector(selector);
    if (!element) {
      throw new Error(`Element not found: ${selector}`);
    }
    return element as HTMLElement;
  }

  private init(): void {
    this.loadContent();
    if (this.bodyInput) this.setupAutoSave();
    this.setupEventListeners();
  }

  private loadContent(): void {
    if (!this.bodyInput) return;

    const textPostBody = localStorage.getItem('post-body');
    if (textPostBody && textPostBody !== "undefined") {
      this.editor.innerHTML = textPostBody;
    }

    const bodyText = this.bodyInput.value;
    if (bodyText) {
      this.editor.innerHTML = bodyText;
    }
  }

  private setupAutoSave(): void {
    setInterval(() => {
      localStorage.setItem('post-body', this.editor.innerHTML);
    }, 10000);
  }

  private setupEventListeners(): void {
    // UI interactions
    const linkItem = this.getElement('.link-item');
    linkItem.addEventListener('mouseenter', () => this.toggleSubMenu(this.selectItemSub, true));
    linkItem.addEventListener('mouseleave', () => this.toggleSubMenu(this.selectItemSub, false));

    this.imageItem.addEventListener('mouseenter', () => this.toggleSubMenu(this.imageSelectItemSub, true));
    this.imageItem.addEventListener('mouseleave', () => this.toggleSubMenu(this.imageSelectItemSub, false));

    // Editor commands
    this.setupCommandButtons();

    // Image handling
    this.setupImageHandling();

    // Form submission
    document.querySelector('.submit-post-form')?.addEventListener('click', this.handleFormSubmit.bind(this));

    document.querySelector('.submit-edit-post-form')?.addEventListener('click', this.handleEditFormSubmit.bind(this));

    // Selection handling
    this.editor.addEventListener('focusout', this.saveSelection.bind(this));
  }

  private toggleSubMenu(element: HTMLElement, show: boolean): void {
    element.style.display = show ? 'block' : 'none';
  }

  private setupCommandButtons(): void {
    const commands: Record<string, EditorCommand> = {
      '.heading_2': { command: 'formatBlock', value: 'h2' },
      '.heading_3': { command: 'formatBlock', value: 'h3' },
      '.paragraph': { command: 'formatBlock', value: 'p' },
      '.bold-item': { command: 'bold' },
      '.italic-item': { command: 'italic' },
      '.broken-item': { command: 'unlink' },
      '.ordered-item': { command: 'insertOrderedList' },
      '.unordered-item': { command: 'insertUnorderedList' },
      '.quotes-item': { command: 'formatBlock', value: 'BLOCKQUOTE' },
      '.indent-item': { command: 'indent' },
      '.outdent-item': { command: 'outdent' },
      '.undo-item': { command: 'undo' },
      '.redo-item': { command: 'redo' }
    };

    Object.entries(commands).forEach(([selector, { command, value }]) => {
      document.querySelector(selector)?.addEventListener('click', () => this.executeCommand(command, value));
    });

    // Special cases
    const deleteItem = this.getElement('.delete-item');
    deleteItem.addEventListener('click', () => this.selectItemInput.value = '');

    const imageDeleteItem = this.getElement('.image-delete-item');
    imageDeleteItem.addEventListener('click', (e) => {
      e.stopImmediatePropagation();
      this.imageSelectItemInput.value = '';
    });

    const checkedItem = this.getElement('.checked-item');
    checkedItem.addEventListener('click', () => {
      const input = this.selectItemInput.value;
      this.selectItemInput.value = '';
      this.toggleSubMenu(this.selectItemSub, false);
      this.executeCommand('createLink', input);
    });

    const imageCheckedItem = this.getElement('.image-checked-item');
    imageCheckedItem.addEventListener('click', (e) => {
      e.stopImmediatePropagation();
      const input = this.imageSelectItemInput.value;
      this.imageSelectItemInput.value = '';
      
      if (input) {
        const images = this.editor.querySelectorAll('img');
        if (images.length) {
          const lastImage = images[images.length - 1] as HTMLImageElement;
          lastImage.alt = input;
          this.toggleSubMenu(this.imageSelectItemSub, false);
        }
      }
    });

    this.imageSelectItemSub.addEventListener('click', (e) => e.stopImmediatePropagation());
  }

  private setupImageHandling(): void {
    this.imageItem.addEventListener('click', () => this.uploadImage.click());

    this.uploadImage.addEventListener('change', () => {
      const selectedFile = this.uploadImage.files?.[0];
      if (!selectedFile) return;
      
      const formData = new FormData();
      formData.append('upload_image_form_input', selectedFile);
      
      const type = this.uploadImage.dataset.type;
      if (type === 'post' || type === 'comment') {
        formData.append('type', type);
      }
      
      this.uploadImageToServer(formData);
    });
  }

  private async uploadImageToServer(formData: FormData): Promise<void> {
    try {
      const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
      if (!csrfToken) {
        throw new Error('CSRF token not found');
      }

      const response = await fetch('/user/image/upload', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': csrfToken
        }
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const { url }: { url: string } = await response.json();
      this.executeCommand('insertImage', url);
    } catch (error) {
      console.error('Error uploading image:', error);
      // Здесь можно добавить уведомление пользователю об ошибке
    }
  }

  private executeCommand(command: string, value: string | null = null): void {
    this.editor.focus();
    this.restoreSelection();
    document.execCommand(command, false, value === null ? undefined : value);
  }

  private restoreSelection(): void {
    if (!this.savedRange) return;
    
    const selection = window.getSelection();
    if (selection) {
      selection.removeAllRanges();
      selection.addRange(this.savedRange);
    } else if ((document as any).selection) { // IE fallback
      (this.savedRange as any).select();
    }
  }

  private saveSelection(): void {
    const selection = window.getSelection();
    if (selection && selection.rangeCount > 0) {
      this.savedRange = selection.getRangeAt(0);
    } else if ((document as any).selection) { // IE fallback
      this.savedRange = (document as any).selection.createRange();
    }
  }

  private handleFormSubmit(e: Event): void {
    e.preventDefault();
    if (!this.bodyInput) return;
    this.bodyInput.value = this.editor.innerHTML;
    this.cleanupStorage();
    const form = this.getElement('#create-post-form') as HTMLFormElement;
    form.submit();
  }

  private handleEditFormSubmit(e: Event): void {
    e.preventDefault();
    if (!this.bodyInput) return;
    this.bodyInput.value = this.editor.innerHTML;
    const caption = this.getElement('#caption') as HTMLInputElement;
    const firstChild = this.editor.children[0];
    caption.value = firstChild ? `<p>${firstChild.innerHTML}</p>` : '';
    this.cleanupStorage();
    const form = this.getElement('#create-post-form') as HTMLFormElement;
    form.submit();
  }

  private cleanupStorage(): void {
    localStorage.removeItem('post-body');
    localStorage.removeItem('title-post-image-url');
  }
}

// Initialize the editor when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.text-editor-body')) {
    new TextEditor();
  }
});
