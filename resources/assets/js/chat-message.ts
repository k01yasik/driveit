import { escape } from 'lodash';

interface ChatMessage {
    id?: number;
    profileUrl: string;
    avatar: string | null;
    username: string;
    time: string;
    sanitizedText: string;
}

export function appendChatMessage(conversation: Element, message: ChatMessage): void {
    const profileUrl = escape(message.profileUrl);
    const idAttribute = message.id === undefined ? '' : ` data-message-id="${message.id}"`;
    const avatarClass = message.id === undefined ? 'message-header-avatar circle' : 'message-header-avatar';

    conversation.insertAdjacentHTML('beforeend', `
        <div class="message-wrapper"${idAttribute}>
            <div class="message-header">
                <a href="${profileUrl}" class="message-header-link">
                    <img src="${escape(message.avatar ?? '')}" class="${avatarClass}">
                </a>
            </div>
            <div class="message-body">
                <div class="message-body-header">
                    <a href="${profileUrl}" class="message-header-name">${escape(message.username)}</a>
                    <div class="message-body-header-time">${escape(message.time)}</div>
                </div>
                <div class="message-body-content">${message.sanitizedText}</div>
            </div>
        </div>
    `);
}
