import { appendChatMessage } from './chat-message';

interface MessageResponse {
    url: string;
    avatar: string | null;
    username: string;
    time: string;
    text: string;
}

document.addEventListener('DOMContentLoaded', () => {
    const conversation = document.querySelector<HTMLElement>('[data-message-url]');
    const editor = document.querySelector<HTMLElement>('.text-editor-body');
    const url = conversation?.dataset.messageUrl;
    const friendId = conversation?.dataset.friend;
    if (!conversation || !editor || !url || !friendId) return;

    let sending = false;
    editor.addEventListener('keydown', async (event) => {
        if (!event.ctrlKey || event.key !== 'Enter') return;
        event.preventDefault();
        if (sending || (!editor.textContent?.trim() && !editor.querySelector('img'))) return;

        sending = true;
        const message = editor.innerHTML;
        try {
            const result = await sendMessage(url, friendId, message);
            if (editor.innerHTML === message) editor.innerHTML = '<div><br></div>';

            appendChatMessage(conversation, {
                profileUrl: result.url,
                avatar: result.avatar,
                username: result.username,
                time: result.time,
                sanitizedText: result.text,
            });

            const welcome = conversation.querySelector<HTMLElement>('.welcome-chat');
            if (welcome && window.getComputedStyle(welcome).display === 'block') {
                welcome.classList.add('fade-out');
                setTimeout(() => { welcome.style.display = 'none'; }, 200);
            }
        } catch (error) {
            console.error('Message sending failed:', error);
        } finally {
            sending = false;
        }
    });
});

async function sendMessage(url: string, friendId: string, message: string): Promise<MessageResponse> {
    const body = new FormData();
    body.append('friend_id', friendId);
    body.append('message', message);

    const headers = new Headers();
    const token = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
    if (token) headers.set('X-CSRF-TOKEN', token);

    const response = await fetch(url, { method: 'POST', body, headers });
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    return response.json();
}
