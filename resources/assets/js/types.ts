export interface CommentResponse {
  level: string;
  url: string;
  avatar: string;
  username: string;
  created_at: string;
  message: string;
}

export interface CommentData {
  post: string;
  level: string;
  parent: string;
  message: string;
}

export type DOMElementMap = {
  wrapper: HTMLElement;
  commentButton: HTMLButtonElement;
  replyButton: HTMLButtonElement;
  textEditor: HTMLElement;
  commentsWrapper: HTMLElement;
  animateElement: HTMLElement;
  addCommentElement: HTMLElement;
};
