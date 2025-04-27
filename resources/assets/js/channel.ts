# Refactored Code with TypeScript and Modern JavaScript

Here's the refactored code following best practices:

```typescript
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
  userFrom: User;
  url: string;
  text: string;
  createdAt: string;
}

interface FriendRequestEvent {
  urlSender: string;
  avatar: string;
  sender: User;
  friend: User;
}

interface ConfirmFriendRequestEvent {
  sender: User;
}

class RealTimeEventHandler {
  private channelId: number | null;
  private postId: number | null;

  constructor() {
    this.channelId = this.getDataAttributeNumber('.channel', 'id');
    this.postId = this.getDataAttributeNumber('.full-post', 'id');
  }

  public initialize(): void {
    if (this.channelId) {
      this.setupPrivateChannel();
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
      .listen('FriendRequest', (e: FriendRequestEvent) => this.handleFriendRequest(e))
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

  private handleMessageSaved(event: MessageEvent): void {
    const profileBlock = document.querySelector('.profile-block-content');
    if (!profileBlock) return;

    const friendId = parseInt(profileBlock.getAttribute('data-friend') || '0', 10);

    if (friendId === event.userFrom.id) {
      this.appendMessage(profileBlock, event);
    } else {
      this.updateMessageCounter();
    }
  }

  private appendMessage(container: Element, event: MessageEvent): void {
    const messageHtml = `
      <div class="message-wrapper">
        <div class="message-header">
          <a href="${event.url}" class="message-header-link">
            <img src="${event.userFrom.profile?.avatar}" class="message-header-avatar">
          </a>
        </div>
        <div class="message-body">
          <div class="message-body-header">
            <a href="${event.url}" class="message-header-name">${event.userFrom.username}</a>
            <div class="message-body-header-time">${event.createdAt}</div>
          </div>
          <div class="message-body-content">${event.text}</div>
        </div>
      </div>
    `;

    container.insertAdjacentHTML('beforeend', messageHtml);
  }

  private updateMessageCounter(): void {
    const messageCountElement = document.querySelector('.messages-count');
    if (!messageCountElement) return;

    const currentCount = parseInt(messageCountElement.textContent?.replace('+', '') || '0', 10);
    const newCount = currentCount + 1;

    messageCountElement.textContent = `+${newCount}`;

    if (messageCountElement instanceof HTMLElement && messageCountElement.style.display === 'none') {
      this.fadeInElement(messageCountElement);
    }
  }

  private handleFriendRequest(event: FriendRequestEvent): void {
    const friendRequestsElement = document.querySelector('.friend-requests');
    if (!friendRequestsElement) return;

    const currentRequests = parseInt(friendRequestsElement.textContent?.replace('+', '') || '0', 10);
    friendRequestsElement.textContent = `+${currentRequests + 1}`;

    if (friendRequestsElement instanceof HTMLElement && friendRequestsElement.style.display === 'none') {
      this.fadeInElement(friendRequestsElement);
    }

    this.appendFriendRequest(event);
  }

  private appendFriendRequest(event: FriendRequestEvent): void {
    const usersList = document.querySelector('.users-element-request:last-of-type')?.parentElement;
    if (!usersList) return;

    const requestHtml = `
      <li class="users-element-request">
        <a href="${event.urlSender}" class="profile-link">
          <img src="${event.avatar}" class="avatar-image">
        </a>
        <a href="${event.urlSender}" class="profile-name">${event.sender.username}</a>
        <div class="friend-request-button right" data-id="${event.sender.id}" data-username="${event.friend.username}">
          <svg version="1.1" class="public-user-uncheck" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">
            <g>
              <path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65
                c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305
                c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73
                c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path>
            </g>
          </svg>
        </div>
      </li>
    `;

    usersList.insertAdjacentHTML('beforeend', requestHtml);
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

  private fadeInElement(element: HTMLElement, duration = 500): void {
    element.style.display = '';
    element.style.opacity = '0';
    
    let opacity = 0;
    const interval = 16; // ~60fps
    const delta = interval / duration;
    
    const fade = () => {
      opacity += delta;
      if (opacity >= 1) {
        element.style.opacity = '1';
        return;
      }
      
      element.style.opacity = opacity.toString();
      requestAnimationFrame(fade);
    };
    
    requestAnimationFrame(fade);
  }
}
