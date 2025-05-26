import { DOMService } from './dom.service';
import { CommentService } from './comment.service';
import { CommentUI } from './comment.ui';

export class CommentController {
  private domService: DOMService;
  private commentService: CommentService;
  private commentUI: CommentUI;

  constructor() {
    this.domService = new DOMService();
    this.commentService = new CommentService(this.domService);
    this.commentUI = new CommentUI(this.domService);
    this.initializeEvents();
  }

  private initializeEvents(): void {
    const commentButton = this.domService.getElement('commentButton');
    const replyButton = this.domService.getElement('replyButton');

    commentButton?.addEventListener('click', this.handleCommentSubmit.bind(this));
    replyButton?.addEventListener('click', this.handleReplyClick.bind(this));
  }

  private async handleCommentSubmit(event: Event): Promise<void> {
    event.preventDefault();
    
    const wrapper = this.domService.getElement('wrapper');
    const textEditor = this.domService.getElement('textEditor');

    if (!wrapper || !textEditor) return;

    const commentData = {
      post: this.domService.getDatasetValue(wrapper, 'post'),
      level: this.domService.getDatasetValue(wrapper, 'level'),
      parent: this.domService.getDatasetValue(wrapper, 'parent'),
      message: textEditor.innerHTML
    };

    try {
      const result = await this.commentService.submitComment(commentData);
      this.commentUI.clearEditor();
      
      const commentHtml = this.commentUI.createCommentHtml(result);
      this.commentUI.insertComment(commentHtml, this.commentService.getTargetElement());
      
      this.commentService.setTargetElement(null);
    } catch (error) {
      console.error('Error submitting comment:', error);
      // Можно добавить UI уведомление об ошибке
    }
  }
  
  private handleReplyClick(event: Event): void {
    const element = event.currentTarget as HTMLElement;
    const level = parseInt(this.domService.getDatasetValue(element, 'level', '0')) + 1;
    const parent = this.domService.getDatasetValue(element, 'parent');
    const wrapper = this.domService.getElement('wrapper');

    if (wrapper) {
        wrapper.dataset.level = level.toString();
        wrapper.dataset.parent = parent;
    }

    this.commentUI.scrollToCommentElement();

    const clickedParent = element.closest('.comment-item');
    if (!clickedParent) return;

    const clickedParentLevel = parseInt(this.domService.getDatasetValue(clickedParent as HTMLElement, 'level', '0')) + 1;
    let currentElement: Element | null = clickedParent;

    while (currentElement) {
        const nextSibling = currentElement.nextElementSibling;
        if (!nextSibling) break;
        const nextSiblingLevel = parseInt(this.domService.getDatasetValue(nextSibling as HTMLElement, 'level', '0'));
    
        if (nextSiblingLevel < clickedParentLevel) break;
        currentElement = nextSibling;
    }

    this.commentService.setTargetElement((currentElement || clickedParent) as HTMLElement);
  }
}
