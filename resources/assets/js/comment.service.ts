import { CommentData, CommentResponse } from './types';
import { DOMService } from './dom.service';

export class CommentService {
  private targetElement: HTMLElement | null = null;

  constructor(private domService: DOMService) {}

  public async submitComment(data: CommentData): Promise<CommentResponse> {
    const formData = new FormData();
    Object.entries(data).forEach(([key, value]) => formData.append(key, value));

    const response = await fetch("/comment/store", {
      method: "POST",
      body: formData,
      headers: {
        'X-CSRF-TOKEN': this.domService.getCsrfToken()
      }
    });

    if (!response.ok) {
      throw new Error('Failed to submit comment');
    }

    return response.json();
  }

  public setTargetElement(element: HTMLElement | null): void {
    this.targetElement = element;
  }

  public getTargetElement(): HTMLElement | null {
    return this.targetElement;
  }
}
