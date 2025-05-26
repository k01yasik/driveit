import { DOMElementMap } from './types';

export class DOMService {
  private elements: Partial<DOMElementMap> = {};
  private csrfToken: string = '';

  constructor() {
    this.initializeElements();
    this.initializeCsrfToken();
  }

  private initializeElements(): void {
    this.elements = {
      wrapper: document.querySelector('.add-comment-wrapper'),
      commentButton: document.querySelector('.add-comment-button'),
      replyButton: document.querySelector('.reply-button'),
      textEditor: document.querySelector('.text-editor-body'),
      commentsWrapper: document.querySelector('.comments-wrapper'),
      animateElement: document.querySelector('html, body'),
      addCommentElement: document.getElementById('add-comment')
    } as Partial<DOMElementMap>;
  }

  private initializeCsrfToken(): void {
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    this.csrfToken = csrfMeta?.getAttribute('content') || '';
  }

  public getElement<K extends keyof DOMElementMap>(key: K): Partial<DOMElementMap>[K] | null {
    return this.elements[key] ?? null;
  }

  public getCsrfToken(): string {
    return this.csrfToken;
  }

  public getDatasetValue(element: HTMLElement | null, key: string, defaultValue = ''): string {
    return element?.dataset[key] ?? defaultValue;
  }
}
