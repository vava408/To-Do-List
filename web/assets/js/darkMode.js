(function () {
    const root = document.documentElement;

    function updateToggleState(theme) {
        const toggle = document.querySelector('#theme-toggle');
        if (toggle) {
            toggle.checked = theme === 'dark';
        }
    }

    function setTheme(theme) {
        root.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        updateToggleState(theme);
    }

    function toggleTheme() {
        const currentTheme = root.getAttribute('data-theme') || 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
    }

    function initTheme() {
        const storedTheme = localStorage.getItem('theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = storedTheme || (systemPrefersDark ? 'dark' : 'light');
        setTheme(theme);
    }

    // Initialisation
    initTheme();

    // Gestionnaire d'événements
    document.addEventListener('DOMContentLoaded', () => {
        const toggleInput = document.querySelector('[data-theme-toggler]');
        if (toggleInput) {
            toggleInput.addEventListener('change', toggleTheme);
            // Synchroniser l'état initial du toggle
            updateToggleState(root.getAttribute('data-theme'));
        }
    });
})();