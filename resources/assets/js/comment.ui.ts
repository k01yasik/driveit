import { HtmlElementCreator } from './createHtmlElement';
import { CommentResponse } from './types';
import { DOMService } from './dom.service';

export class CommentUI {
  private htmlElementCreator = new HtmlElementCreator();

  constructor(private domService: DOMService) {}

  public clearEditor(): void {
    const editor = this.domService.getElement('textEditor');
    if (editor) {
      localStorage.removeItem('post-body');
      editor.innerHTML = '<div><br /></div>';
    }
  }

  public createCommentHtml(comment: CommentResponse): string {
    return `
      <div class='comment-item level-${comment.level}' data-level='${comment.level}'>
        <div class='header'>
          <a href='${comment.url}' class='user-avatar-link header-item'>
            <img src='${comment.avatar}' class='user-avatar' alt='${comment.username}' /> 
          </a>
          <a href='${comment.url}' class='post-author header-item'>${comment.username}</a>
          <div class='right'>${comment.created_at}</div>
        </div>
        <div class='body'>
          <p>${comment.message}</p>
        </div>
      </div>
    `;
  }

  public insertComment(html: string, targetElement: HTMLElement | null = null): void {
    const commentElement = this.htmlElementCreator.createFromString(html);
    const commentsWrapper = this.domService.getElement('commentsWrapper');

    if (!commentElement) return;

    if (targetElement) {
      targetElement.insertAdjacentElement('afterend', commentElement as Element);
    } else if (commentsWrapper) {
      commentsWrapper.insertAdjacentElement('afterend', commentElement as Element);
    }
  }

  public scrollToCommentElement(): void {
    const addCommentElement = this.domService.getElement('addCommentElement');
    if (addCommentElement) {
        window.scrollTo({
            top: addCommentElement.offsetTop,
            behavior: 'smooth' as ScrollBehavior
        });
    }
  }
}
