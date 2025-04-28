type ExpandableElement = HTMLElement & {
  nextElementSibling: HTMLElement | null;
};

const ANIMATION_DURATION_MS = 200;

function handleExpandableItemClick(this: ExpandableElement): void {
  const content = this.nextElementSibling;
  if (!(content instanceof HTMLElement)) return;

  const isExpanded = !content.classList.contains('expanded');
  
  // CSS-анимация через классы
  content.classList.toggle('expanded', isExpanded);
  
  // Обновление иконки после задержки
  const caret = this.querySelector<HTMLElement>('.caret-down');
  window.setTimeout(() => {
    caret?.classList.toggle('rotate-svg', isExpanded);
  }, ANIMATION_DURATION_MS);
}

function initializeExpandableItems(): void {
  document.querySelectorAll<ExpandableElement>('.expanded-item').forEach((item) => {
    item.addEventListener('click', handleExpandableItemClick);
  });
}

// Инициализация при загрузке документа
if (document.readyState !== 'loading') {
  initializeExpandableItems();
} else {
  document.addEventListener('DOMContentLoaded', initializeExpandableItems);
}
