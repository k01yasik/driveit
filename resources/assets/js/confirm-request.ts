interface FriendRequestButton extends HTMLButtonElement {
    dataset: {
        id: string;
        username: string;
    };
}

interface RequestListElement extends HTMLElement {
    style: CSSStyleDeclaration;
}

const handleFriendRequest = async (event: Event): Promise<void> => {
    const element = event.target as FriendRequestButton;
    const { id, username } = element.dataset;

    try {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('username', username);

        const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;

        const response = await fetch('/user/friends/requests', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken || '',
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        // Update button with checkmark SVG
        element.innerHTML = `
            <svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
            </svg>
        `;

        const friendRequests = document.querySelector<HTMLElement>('.friend-requests');
        if (!friendRequests) return;

        const parentElement = element.parentElement as RequestListElement;
        if (!parentElement) return;

        const requestCountElement = friendRequests;
        let requests = parseInt(requestCountElement.textContent?.replace('+', '') || '0');

        requests -= 1;

        const fadeOutAndRemove = (element: HTMLElement, callback?: () => void): void => {
            element.style.opacity = '1';
            
            const fadeEffect = setInterval(() => {
                if (parseFloat(element.style.opacity) > 0) {
                    element.style.opacity = (parseFloat(element.style.opacity) - 0.1).toString();
                } else {
                    clearInterval(fadeEffect);
                    element.remove();
                    callback?.();
                }
            }, 50);
        };

        if (requests > 0) {
            fadeOutAndRemove(parentElement);
            requestCountElement.textContent = `+${requests}`;
        } else {
            fadeOutAndRemove(friendRequests);
            fadeOutAndRemove(parentElement, () => {
                const requestListElement = document.querySelector<HTMLElement>('.request-list-element');
                requestListElement?.style.setProperty('display', 'block', 'important');
                requestListElement?.style.setProperty('opacity', '1', 'important');
            });
        }
    } catch (error) {
        console.error('Error processing friend request:', error);
        // Можно добавить обработку ошибок, например, показать сообщение пользователю
    }
};

// Инициализация обработчика событий
document.querySelector('.request-list')?.addEventListener('click', (event) => {
    const target = event.target as HTMLElement;
    if (target.closest('.friend-request-button')) {
        handleFriendRequest(event);
    }
});
