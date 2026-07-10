// Accordion açılış/kapanış animasyonu (Brief "Tasarımcıdan Beklentiler" — interaction state'leri).
// Native <details> toggle'ı anlık olduğu için max-height'i JS ile animasyonlu geçiriyoruz.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.accordion-item').forEach((item) => {
        const summary = item.querySelector('summary');
        const body = item.querySelector('.accordion-panel');
        if (!summary || !body) return;

        summary.addEventListener('click', (e) => {
            e.preventDefault();

            if (item.open) {
                const startHeight = body.scrollHeight;
                body.style.height = startHeight + 'px';
                body.offsetHeight; // reflow
                body.style.height = '0px';
                body.addEventListener('transitionend', function onClose() {
                    item.open = false;
                    body.style.height = '';
                    body.removeEventListener('transitionend', onClose);
                }, { once: true });
            } else {
                item.open = true;
                const endHeight = body.scrollHeight;
                body.style.height = '0px';
                body.offsetHeight; // reflow
                body.style.height = endHeight + 'px';
                body.addEventListener('transitionend', function onOpen() {
                    body.style.height = '';
                    body.removeEventListener('transitionend', onOpen);
                }, { once: true });
            }
        });
    });
});
