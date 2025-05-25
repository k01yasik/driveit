export class DomUtils {
    public static fadeOut(element: HTMLElement, duration: number, callback?: () => void): void {
        element.style.transition = `opacity ${duration}ms`;
        element.style.opacity = '0';
        
        setTimeout(() => {
            element.remove();
            callback?.();
        }, duration);
    }

    public static fadeIn(element: HTMLElement, duration: number): void {
        element.style.opacity = '0';
        element.style.display = 'block';
        element.style.transition = `opacity ${duration}ms`;
        
        // Trigger reflow
        void element.offsetHeight;
        
        element.style.opacity = '1';
    }
}
