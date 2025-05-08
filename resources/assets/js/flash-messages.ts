const alerts = document.querySelectorAll<HTMLElement>('.alert');
alerts.forEach(alert => {
    // Плавное исчезновение (аналог fadeOut)
    alert.style.transition = 'opacity 0.5s';
    alert.style.opacity = '0';
    
    // Удаление из DOM после анимации
    setTimeout(() => alert.remove(), 5000);
});
