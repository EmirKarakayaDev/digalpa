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

// Proje galerisi lightbox (Brief §09: "2x2 + N görsel daha" — tıklanınca tam boyutta,
// ok tuşlarıyla gezilebilir görüntüleme).
document.addEventListener('DOMContentLoaded', () => {
    const galleryEl = document.querySelector('.project-gallery');
    if (!galleryEl) return;

    const images = JSON.parse(galleryEl.dataset.gallery || '[]');
    const lightbox = document.getElementById('gallery-lightbox');
    const imgEl = document.getElementById('gallery-lightbox-img');
    const counterEl = document.getElementById('gallery-lightbox-counter');
    if (!images.length || !lightbox || !imgEl) return;

    let currentIndex = 0;

    function show(index) {
        currentIndex = (index + images.length) % images.length;
        imgEl.src = images[currentIndex];
        counterEl.textContent = (currentIndex + 1) + ' / ' + images.length;
    }

    function open(index) {
        show(index);
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
    }

    galleryEl.querySelectorAll('.gallery-thumb').forEach((thumb) => {
        thumb.addEventListener('click', () => open(parseInt(thumb.dataset.index, 10)));
    });

    document.getElementById('gallery-lightbox-close')?.addEventListener('click', close);
    document.getElementById('gallery-lightbox-prev')?.addEventListener('click', () => show(currentIndex - 1));
    document.getElementById('gallery-lightbox-next')?.addEventListener('click', () => show(currentIndex + 1));
    lightbox.addEventListener('click', (e) => { if (e.target === lightbox) close(); });

    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(currentIndex - 1);
        if (e.key === 'ArrowRight') show(currentIndex + 1);
    });
});
