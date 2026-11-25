import { escape } from 'lodash';

class MessageEditor {
    private static sending = false;
    public static init(): void {
        if (!document.querySelector('[data-message-url]')) return;
        const editor = document.querySelector('.text-editor-body');
        if (!editor) return;

        editor.addEventListener('keydown', async (e: KeyboardEvent) => {
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                await this.handleMessageSubmit();
            }
        });
    }

    private static async handleMessageSubmit(): Promise<void> {
        const dataElement = document.querySelector('[data-message-url]');
        if (!dataElement) return;

        const url = dataElement.getAttribute('data-message-url');
        const friendId = dataElement.getAttribute('data-friend');
        const editor = document.querySelector('.text-editor-body');

        if (!url || !friendId || !editor || this.sending) return;
        if (!editor.textContent?.trim() && !editor.querySelector('img')) return;

        this.sending = true;

        const message = editor.innerHTML;

        try {
            const result = await this.sendMessage(url, friendId, message);
            if (editor.innerHTML === message) {
                editor.innerHTML = '<div><br></div>';
            }
            this.displayNewMessage(result);
            this.hideWelcomeChat();
        } catch (error) {
            console.error('Message sending failed:', error);
        } finally {
            this.sending = false;
        }
    }

    private static async sendMessage(url: string, friendId: string, message: string): Promise<MessageResponse> {
        const formData = new FormData();
        formData.append('friend_id', friendId);
        formData.append('message', message);

        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    private static displayNewMessage(result: MessageResponse): void {
        const messageHTML = `
            <div class="message-wrapper">
                <div class="message-header">
                    <a href="${escape(result.url)}" class="message-header-link">
                        <img src="${escape(result.avatar ?? '')}" class="message-header-avatar circle">
                    </a>
                </div>
                <div class="message-body">
                    <div class="message-body-header">
                        <a href="${escape(result.url)}" class="message-header-name">${escape(result.username)}</a>
                        <div class="message-body-header-time">${escape(result.time)}</div>
                    </div>
                    <div class="message-body-content">
                        ${result.text}
                    </div>
                </div>
            </div>
        `;

        const contentBlock = document.querySelector('[data-message-url]');
        if (contentBlock) {
            contentBlock.insertAdjacentHTML('beforeend', messageHTML);
        }
    }

    private static hideWelcomeChat(): void {
        const welcomeChat = document.querySelector('.welcome-chat');
        if (welcomeChat && window.getComputedStyle(welcomeChat).display === 'block') {
            welcomeChat.classList.add('fade-out');
            setTimeout(() => {
                (welcomeChat as HTMLElement).style.display = 'none';
            }, 200);
        }
    }

    private static getHeaders(): Headers {
        const headers = new Headers();
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (token) {
            headers.append('X-CSRF-TOKEN', token);
        }
        
        return headers;
    }
}

interface MessageResponse {
    url: string;
    avatar: string | null;
    username: string;
    time: string;
    text: string;
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    MessageEditor.init();
});

// CSS для анимации
const style = document.createElement('style');
style.textContent = `
    .fade-out {
        opacity: 0;
        transition: opacity 200ms ease-in-out;
    }
`;
document.head.appendChild(style);
