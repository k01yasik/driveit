class FriendRequest {
    private static HOURGLASS_ICON = `
        <svg version="1.1" class="hourglass-friend-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60" xml:space="preserve">
            <g>
                <path d="M54,58h-3v-4h-5V43.778c0-2.7-1.342-5.208-3.589-6.706L31.803,30l10.608-7.072C44.658,21.43,46,18.922,46,16.222V6h5V2h3
                c0.552,0,1-0.447,1-1s-0.448-1-1-1h-3h-1H10H9H6C5.448,0,5,0.447,5,1s0.448,1,1,1h3v4h5v10.222c0,2.7,1.342,5.208,3.589,6.706
                L28.197,30l-10.608,7.072C15.342,38.57,14,41.078,14,43.778V54H9v4H6c-0.552,0-1,0.447-1,1s0.448,1,1,1h3h1h40h1h3
                c0.552,0,1-0.447,1-1S54.552,58,54,58z M18.698,21.264C17.009,20.137,16,18.252,16,16.222V6h28v10.222
                c0,2.03-1.009,3.915-2.698,5.042L30,28.798L18.698,21.264z M16,43.778c0-2.03,1.009-3.915,2.698-5.042L30,31.202l11.302,7.534
                C42.991,39.863,44,41.748,44,43.778V54H16V43.778z"/>
            </g>
        </svg>
    `;

    private static WAITING_BUTTON_HTML = `
        <div class="waiting" title="Ожидание подтверждения.">
            <div class="svg-wrapper">
                ${this.HOURGLASS_ICON}
            </div>
            <div class="button-title">Ожидание</div>
        </div>
    `;

    public static init(): void {
        document.addEventListener('click', (event) => {
            const target = event.target as HTMLElement;
            const button = target.closest('.request-friend');
            
            if (button) {
                event.preventDefault();
                this.handleFriendRequest(button);
            }
        });
    }

    private static async handleFriendRequest(button: HTMLElement): Promise<void> {
        const friendId = button.dataset.friend;
        const username = button.dataset.username;

        if (!friendId || !username) return;

        try {
            await this.sendFriendRequest(friendId, username);
            this.replaceWithWaitingButton(button);
        } catch (error) {
            console.error('Friend request failed:', error);
            // Можно добавить уведомление пользователю
        }
    }

    private static async sendFriendRequest(friendId: string, username: string): Promise<void> {
        const formData = new FormData();
        formData.append('friend', friendId);
        formData.append('username', username);

        const response = await fetch('/user/friends/add', {
            method: 'POST',
            body: formData,
            headers: this.getHeaders()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
    }

    private static replaceWithWaitingButton(button: HTMLElement): void {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = this.WAITING_BUTTON_HTML.trim();
        const newElement = wrapper.firstChild as HTMLElement | null;
        if (newElement) {
            button.replaceWith(newElement);
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

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    FriendRequest.init();
});
