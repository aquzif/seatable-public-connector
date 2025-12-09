const enableOfflineBanner = () => {
    const banner = document.getElementById('offline-banner');

    if (!banner) {
        return;
    }

    const showBanner = () => {
        banner.classList.remove('hidden');
        banner.setAttribute('aria-hidden', 'false');
    };

    const hideBanner = () => {
        banner.classList.add('hidden');
        banner.setAttribute('aria-hidden', 'true');
    };

    const syncBanner = () => {
        if (navigator.onLine) {
            hideBanner();
        } else {
            showBanner();
        }
    };

    window.addEventListener('online', syncBanner);
    window.addEventListener('offline', syncBanner);
    syncBanner();
};

const registerServiceWorker = () => {
    if (!('serviceWorker' in navigator)) {
        return;
    }

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js').catch(() => {
            // The registration failed; we intentionally avoid interrupting the user experience.
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    enableOfflineBanner();
    registerServiceWorker();
});
