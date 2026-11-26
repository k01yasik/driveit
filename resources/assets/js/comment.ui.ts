import { escape } from 'lodash';
import { HtmlElementCreator } from './createHtmlElement';
import { CommentResponse } from './types';
import { DOMService } from './dom.service';

export class CommentUI {
  private htmlElementCreator = new HtmlElementCreator();

  constructor(private domService: DOMService) {}

  public clearEditor(): void {
    const editor = this.domService.getElement('textEditor');
    if (editor) {
      editor.innerHTML = '<div><br /></div>';
    }
  }

  public createCommentHtml(comment: CommentResponse): string {
    return `
      <div class='comment-item level-${escape(String(comment.level))}' data-level='${escape(String(comment.level))}'>
        <div class='header'>
          <a href='${escape(String(comment.url))}' class='user-avatar-link header-item'>
            <img src='${escape(String(comment.avatar))}' class='user-avatar' alt='${escape(String(comment.username))}' />
          </a>
          <a href='${escape(String(comment.url))}' class='post-author header-item'>${escape(String(comment.username))}</a>
          <div class='right'>${escape(String(comment.created_at))}</div>
        </div>
        <div class='body'>
          ${comment.message}
        </div>
      </div>
    `;
  }

  public insertComment(html: string, targetElement: Element | null = null): void {
    const commentElement = this.htmlElementCreator.createFromString(html);
    const commentsWrapper = this.domService.getElement('commentsWrapper');

    if (!commentElement) return;

    if (targetElement) {
      targetElement.insertAdjacentElement('afterend', commentElement as Element);
    } else if (commentsWrapper) {
      commentsWrapper.querySelector('.empty-comments')?.remove();
      commentsWrapper.append(commentElement);
    }
  }

  public scrollToCommentElement(): void {
    const addCommentElement = this.domService.getElement('addCommentElement');
    if (addCommentElement) {
        window.scrollTo({
            top: addCommentElement.offsetTop,
            behavior: 'smooth' as ScrollBehavior
        } as ScrollToOptions);
    }
  }
}
