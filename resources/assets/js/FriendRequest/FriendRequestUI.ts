import { DomUtils } from './DomUtils';

interface FriendRequestUIOptions {
    counterSelector?: string;
    parentSelector?: string;
    emptyStateSelector?: string;
}

export class FriendRequestUI {
    public static updateUI(
        button: HTMLButtonElement,
        options: FriendRequestUIOptions = {}
    ): void {
        const {
            counterSelector = '.friend-requests',
            parentSelector = '.request-list > *',
            emptyStateSelector = '.request-list-element'
        } = options;

        this.setCheckmarkIcon(button);
        
        const counter = document.querySelector<HTMLElement>(counterSelector);
        const currentCount = counter ? parseInt(counter.textContent?.replace('+', '') || '0') : 0;
        
        this.updateCounter(counter, currentCount);
        this.handleParentElement(button, parentSelector, emptyStateSelector, currentCount);
    }

    private static setCheckmarkIcon(button: HTMLButtonElement): void {
        button.innerHTML = `
            <svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26">
                <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
            </svg>
        `;
    }

    private static updateCounter(counter: HTMLElement | null, currentCount: number): void {
        if (!counter) return;

        const newCount = currentCount - 1;

        if (newCount > 0) {
            counter.textContent = `+${newCount}`;
        } else {
            DomUtils.fadeOut(counter, 500);
        }
    }

    private static handleParentElement(
        button: HTMLButtonElement,
        parentSelector: string,
        emptyStateSelector: string,
        currentCount: number
    ): void {
        const parent = button.closest<HTMLElement>(parentSelector);
        if (!parent) return;

        DomUtils.fadeOut(parent, 500, () => {
            if (currentCount <= 1) {
                const emptyState = document.querySelector<HTMLElement>(emptyStateSelector);
                if (emptyState) DomUtils.fadeIn(emptyState, 500);
            }
        });
    }
}
