import { FriendRequestApiService } from './FriendRequestApiService';
import { FriendRequestUI } from './FriendRequestUI';

interface FriendRequestHandlerOptions {
    apiUrl?: string;
    buttonSelector?: string;
    containerSelector?: string;
    uiOptions?: {
        counterSelector?: string;
        parentSelector?: string;
        emptyStateSelector?: string;
    };
}

export class FriendRequestHandler {
    private static options: FriendRequestHandlerOptions = {
        apiUrl: '/user/friends/requests',
        buttonSelector: '.friend-request-button',
        containerSelector: '.request-list',
        uiOptions: {
            counterSelector: '.friend-requests',
            parentSelector: '.request-list > *',
            emptyStateSelector: '.request-list-element'
        }
    };

    public static init(options: FriendRequestHandlerOptions = {}): void {
        this.options = { ...this.options, ...options };
        
        document.querySelector(this.options.containerSelector!)
            ?.addEventListener('click', this.handleRequest.bind(this));
    }

    private static async handleRequest(event: Event): Promise<void> {
        const button = (event.target as HTMLElement).closest(
            this.options.buttonSelector!
        );
        if (!button) return;

        event.preventDefault();
        
        try {
            const { id, username } = (button as HTMLButtonElement).dataset;
            if (!id || !username) return;

            await FriendRequestApiService.sendRequest(
                id,
                username,
                this.options.apiUrl
            );
            
            FriendRequestUI.updateUI(
                button as HTMLButtonElement,
                this.options.uiOptions
            );
        } catch (error) {
            console.error('Friend request error:', error);
        }
    }
}
