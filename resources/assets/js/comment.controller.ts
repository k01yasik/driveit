import { DOMService } from './dom.service';
import { CommentService } from './comment.service';
import { CommentUI } from './comment.ui';

export class CommentController {
  private domService = new DOMService();
  private commentService = new CommentService(this.domService);
  private commentUI = new CommentUI(this.domService);
  private replyTarget: Element | null = null;
  private submitting = false;

  constructor() {
    const wrapper = this.domService.getElement('wrapper');
    if (!wrapper) return;

    this.domService.getElement('commentButton')?.addEventListener('click', (event) => this.submit(event));
    document.addEventListener('click', (event) => {
      const reply = (event.target as Element).closest<HTMLElement>('.reply-button');
      if (reply && !this.submitting) this.selectReply(reply, wrapper);
    });
  }

  private async submit(event: Event): Promise<void> {
    event.preventDefault();
    const wrapper = this.domService.getElement('wrapper');
    const editor = this.domService.getElement('textEditor');
    if (!wrapper || !editor || this.submitting) return;

    const message = editor.innerHTML;
    this.submitting = true;
    try {
      const comment = await this.commentService.submitComment({
        post: wrapper.dataset.post ?? '',
        level: wrapper.dataset.level ?? '0',
        parent: wrapper.dataset.parent ?? '0',
        message
      });

      this.commentUI.insertComment(this.commentUI.createCommentHtml(comment), this.replyTarget);
      if (editor.innerHTML === message) this.commentUI.clearEditor();
      wrapper.dataset.level = '0';
      wrapper.dataset.parent = '0';
      this.replyTarget = null;
    } catch (error) {
      console.error('Error submitting comment:', error);
    } finally {
      this.submitting = false;
    }
  }

  private selectReply(button: HTMLElement, wrapper: HTMLElement): void {
    const parent = button.closest<HTMLElement>('.comment-item');
    const level = Number(button.dataset.level) + 1;
    if (!parent || !button.dataset.parent || !Number.isInteger(level) || level < 1 || level > 5) return;

    wrapper.dataset.level = String(level);
    wrapper.dataset.parent = button.dataset.parent;

    let target: Element = parent;
    while (target.nextElementSibling?.matches('.comment-item')) {
      const next = target.nextElementSibling as HTMLElement;
      if (Number(next.dataset.level) < level) break;
      target = next;
    }

    this.replyTarget = target;
    this.commentUI.scrollToCommentElement();
  }
}
