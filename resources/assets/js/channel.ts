import { escape } from 'lodash';

interface User {
  id: number;
  username: string;
  url: string;
  avatar: string;
  profile?: {
    avatar: string;
  };
}

interface MessageEvent {
  sender: { id: number; username: string; profile_url: string; avatar: string | null };
  message: { id: number; text: string; created_at: string };
}

interface ConfirmFriendRequestEvent {
  sender: Pick<User, 'id'>;
}

class RealTimeEventHandler {
  private channelId: number | null;
  private postId: number | null;
  private pendingReads = new Set<number>();

  constructor() {
    this.channelId = this.getDataAttributeNumber('.channel', 'id');
    this.postId = this.getDataAttributeNumber('.full-post', 'id');
  }

  public initialize(): void {
    if (this.channelId) {
      this.setupPrivateChannel();
      document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
          void this.markPendingMessagesRead();
        }
      });
    }

    if (this.postId) {
      this.setupPostChannel();
    }
  }

  private getDataAttributeNumber(selector: string, attribute: string): number | null {
    const element = document.querySelector(selector);
    if (!element) return null;

    const value = element.getAttribute(`data-${attribute}`);
    return value ? parseInt(value, 10) : null;
  }

  private setupPrivateChannel(): void {
    if (!this.channelId) return;

    const echoChannel = window.Echo.private(`user.${this.channelId}`);

    echoChannel
      .listen('MessageSaved', (e: MessageEvent) => this.handleMessageSaved(e))
      .listen('FriendRequestSent', () => this.handleFriendRequest())
      .listen('ConfirmFriendRequest', (e: ConfirmFriendRequestEvent) => this.handleConfirmFriendRequest(e));
  }

  private setupPostChannel(): void {
    if (!this.postId) return;

    console.log('Post_id is present');
    console.log(`post.${this.postId}`);

    const echoChannel = window.Echo.join(`post.${this.postId}`);

    echoChannel
      .joining((user: User) => this.handleUserJoining(user))
      .here((users: User[]) => this.handleUsersHere(users))
      .leaving((user: User) => this.handleUserLeaving(user));
  }

  private async handleMessageSaved(event: MessageEvent): Promise<void> {
    const conversation = document.querySelector<HTMLElement>('[data-read-url]');
    if (!conversation || Number(conversation.dataset.friend) !== event.sender.id) {
      this.updateMessageCounter();
      return;
    }

    const messageId = event.message.id;
    if (messageId && conversation.querySelector(`[data-message-id="${messageId}"]`)) return;

    this.appendMessage(conversation, event);
    conversation.querySelector('.welcome-chat')?.remove();
    if (messageId && document.visibilityState === 'visible' && await this.markRead(messageId)) return;

    this.updateMessageCounter();
    if (messageId) this.pendingReads.add(messageId);
  }

  private async markPendingMessagesRead(): Promise<void> {
    for (const id of Array.from(this.pendingReads)) {
      this.pendingReads.delete(id);
      if (await this.markRead(id)) {
        this.updateMessageCounter(-1);
      } else {
        this.pendingReads.add(id);
        break;
      }
    }
  }

  private async markRead(id: number): Promise<boolean> {
    const csrf = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
    const url = document.querySelector<HTMLElement>('[data-read-url]')?.dataset.readUrl;
    if (!csrf || !url) return false;

    try {
      const response = await fetch(url, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
        body: JSON.stringify({ id })
      });
      return response.ok;
    } catch (error) {
      console.error('Could not mark message as read', error);
      return false;
    }
  }

  private appendMessage(container: Element, event: MessageEvent): void {
    const messageHtml = `
      <div class="message-wrapper" data-message-id="${event.message.id}">
        <div class="message-header">
          <a href="${escape(event.sender.profile_url)}" class="message-header-link">
            <img src="${escape(event.sender.avatar ?? '')}" class="message-header-avatar">
          </a>
        </div>
        <div class="message-body">
          <div class="message-body-header">
            <a href="${escape(event.sender.profile_url)}" class="message-header-name">${escape(event.sender.username)}</a>
            <div class="message-body-header-time">${escape(event.message.created_at)}</div>
          </div>
          <div class="message-body-content">${event.message.text}</div>
        </div>
      </div>
    `;

    container.insertAdjacentHTML('beforeend', messageHtml);
  }

  private updateMessageCounter(change = 1): void {
    const messageCountElement = document.querySelector('.messages-count');
    if (!messageCountElement) return;

    const currentCount = parseInt(messageCountElement.textContent?.replace('+', '') || '0', 10);
    const newCount = Math.max(0, currentCount + change);

    messageCountElement.textContent = String(newCount);
    messageCountElement.toggleAttribute('hidden', newCount === 0);
  }

  private handleFriendRequest(): void {
    const counter = document.querySelector('.friend-requests');
    if (!counter) return;

    const current = Number(counter.textContent) || 0;
    counter.textContent = `+${current + 1}`;
    counter.removeAttribute('hidden');
  }

  private handleConfirmFriendRequest(event: ConfirmFriendRequestEvent): void {
    const friendElement = document.querySelector(`.friend-id-${event.sender.id}`);
    if (!friendElement) return;

    const lastChild = friendElement.lastElementChild;
    if (!lastChild) return;

    const confirmedHtml = `
      <div class="confirmed right">
        <svg version="1.1" class="checked-friend-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
          <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
        </svg>
      </div>
    `;

    lastChild.insertAdjacentHTML('afterend', confirmedHtml);
    lastChild.remove();
  }

  private handleUserJoining(user: User): void {
    const readersBody = document.querySelector('.article-readers-body');
    if (!readersBody) return;

    const userHtml = `
      <div class="post-reader flex flex-v-center" id="user-${user.id}">
        <a href="${user.url}" class="user-avatar-link">
          <img src="${user.avatar}" class="user-avatar" alt="${user.username}">
        </a>
        <a href="${user.url}" class="post-author">${user.username}</a>
      </div>
    `;

    readersBody.insertAdjacentHTML('beforeend', userHtml);
  }

  private handleUsersHere(users: User[]): void {
    const readersBody = document.querySelector('.article-readers-body');
    if (!readersBody || readersBody.children.length > 0) return;

    users.forEach(user => {
      const userHtml = `
        <div class="post-reader flex flex-v-center" id="user-${user.id}">
          <a href="${user.url}" class="user-avatar-link">
            <img src="${user.avatar}" class="user-avatar circle" alt="${user.username}">
          </a>
          <a href="${user.url}" class="post-author">${user.username}</a>
        </div>
      `;
      readersBody.insertAdjacentHTML('beforeend', userHtml);
    });
  }

  private handleUserLeaving(user: User): void {
    const userElement = document.getElementById(`user-${user.id}`);
    if (userElement) {
      userElement.remove();
    }
  }

}

document.addEventListener('DOMContentLoaded', () => {
  new RealTimeEventHandler().initialize();
});
