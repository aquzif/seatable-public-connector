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

const getPreferredTheme = () => {
    const storedTheme = localStorage.getItem('theme');

    if (storedTheme === 'dark' || storedTheme === 'light') {
        return storedTheme;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyTheme = (theme) => {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.setAttribute('data-theme', theme);

    const sunIcons = document.querySelectorAll('[data-theme-icon="sun"]');
    const moonIcons = document.querySelectorAll('[data-theme-icon="moon"]');

    sunIcons.forEach((icon) => icon.classList.toggle('hidden', isDark));
    moonIcons.forEach((icon) => icon.classList.toggle('hidden', !isDark));

    const toggle = document.getElementById('theme-toggle');
    if (toggle) {
        toggle.setAttribute('aria-pressed', isDark.toString());
    }
};

const enableThemeSwitcher = () => {
    const toggle = document.getElementById('theme-toggle');

    const syncTheme = (theme) => {
        localStorage.setItem('theme', theme);
        applyTheme(theme);
    };

    const preferredTheme = getPreferredTheme();
    applyTheme(preferredTheme);

    if (toggle) {
        toggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            syncTheme(nextTheme);
        });
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
        const storedTheme = localStorage.getItem('theme');
        if (!storedTheme) {
            applyTheme(event.matches ? 'dark' : 'light');
        }
    });
};

const initialize = () => {
    enableOfflineBanner();
    enableThemeSwitcher();
    registerServiceWorker();
};

document.addEventListener('DOMContentLoaded', initialize);
