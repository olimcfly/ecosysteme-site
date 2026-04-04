const faqButtons = document.querySelectorAll('.faq-question');

faqButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const item = button.closest('.faq-item');
        const expanded = item.classList.contains('active');

        faqButtons.forEach((btn) => {
            const parent = btn.closest('.faq-item');
            parent.classList.remove('active');
            btn.setAttribute('aria-expanded', 'false');
        });

        if (!expanded) {
            item.classList.add('active');
            button.setAttribute('aria-expanded', 'true');
        }
    });
});
