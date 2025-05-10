class MessageEditor {
    private static init(): void {
        const editor = document.querySelector('.text-editor-body');
        if (!editor) return;

        editor.addEventListener('keydown', async (e) => {
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                await this.handleMessageSubmit();
            }
        });
    }

    private static async handleMessageSubmit(): Promise<void> {
        const dataElement = document.querySelector('.profile-block-content');
        if (!dataElement) return;

        const username = dataElement.getAttribute('data-username');
        const friendId = dataElement.getAttribute('data-friend');
        const editor = document.querySelector('.text-editor-body');

        if (!username || !friendId || !editor) return;

        const message = editor.innerHTML;
        editor.innerHTML = '<div><br></div>';
        localStorage.removeItem('post-body');

        try {
            const result = await this.sendMessage(username, friendId, message);
            this.displayNewMessage(result);
            this.hideWelcomeChat();
        } catch (error) {
            console.error('Message sending failed:', error);
            // Можно добавить уведомление пользователю
        }
    }

    private static async sendMessage(username: string, friendId: string, message: string): Promise<MessageResponse> {
        const formData = new FormData();
        formData.append('username', username);
        formData.append('friend_id', friendId);
        formData.append('message', message);

        const response = await fetch('/user/messages/store', {
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
                    <a href="${result.url}" class="message-header-link">
                        <img src="${result.avatar}" class="message-header-avatar circle">
                    </a>
                </div>
                <div class="message-body">
                    <div class="message-body-header">
                        <a href="${result.url}" class="message-header-name">${result.username}</a>
                        <div class="message-body-header-time">${result.time}</div>
                    </div>
                    <div class="message-body-content">
                        ${result.text}
                    </div>
                </div>
            </div>
        `;

        const contentBlock = document.querySelector('.profile-block-content');
        if (contentBlock) {
            contentBlock.insertAdjacentHTML('beforeend', messageHTML);
        }
    }

    private static hideWelcomeChat(): void {
        const welcomeChat = document.querySelector('.welcome-chat');
        if (welcomeChat && window.getComputedStyle(welcomeChat).display === 'block') {
            welcomeChat.classList.add('fade-out');
            setTimeout(() => {
                welcomeChat.style.display = 'none';
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
    avatar: string;
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
