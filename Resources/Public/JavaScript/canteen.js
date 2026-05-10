(() => {
    const initCanteenWidget = (container) => {
        const nav = container.querySelector('.mai-canteen__nav');
        if (!nav) return;

        const prevBtn = nav.querySelector('.mai-canteen__nav-btn--prev');
        const nextBtn = nav.querySelector('.mai-canteen__nav-btn--next');

        const updateNavState = () => {
            const url = new URL(window.location.href);
            const offset = parseInt(url.searchParams.get('tx_maicanteen_week[offset]') ?? '0', 10);
            if (prevBtn) prevBtn.setAttribute('aria-disabled', String(offset <= -4));
        };

        updateNavState();
    };

    document.querySelectorAll('[data-canteen-container]').forEach(initCanteenWidget);
})();
