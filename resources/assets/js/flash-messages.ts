document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll<HTMLElement>('.alert-success:not([role="alert"])').forEach((alert) => {
        window.setTimeout(() => alert.remove(), 5000);
    });
});
