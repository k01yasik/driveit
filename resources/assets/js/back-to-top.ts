document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector<HTMLButtonElement>('.back-to-top');
    if (!button) return;

    let scheduled = false;
    const updateVisibility = () => {
        scheduled = false;
        button.classList.toggle('back-to-top--visible', window.scrollY > 500);
    };

    updateVisibility();
    window.addEventListener('scroll', () => {
        if (scheduled) return;
        scheduled = true;
        requestAnimationFrame(updateVisibility);
    }, { passive: true });

    button.addEventListener('click', () => {
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
    });
});
