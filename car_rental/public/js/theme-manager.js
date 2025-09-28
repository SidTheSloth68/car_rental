/*
 * Dark Theme Manager
 * JavaScript utilities for managing dark theme
 */

class ThemeManager {
    constructor() {
        this.currentTheme = this.getStoredTheme() || this.getSystemTheme();
        this.init();
    }

    init() {
        this.applyTheme(this.currentTheme);
        this.createToggleButton();
        this.bindEvents();
    }

    getSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    getStoredTheme() {
        return localStorage.getItem('caravel-theme');
    }

    storeTheme(theme) {
        localStorage.setItem('caravel-theme', theme);
    }

    applyTheme(theme) {
        const body = document.body;
        
        // Add transition class to prevent flickering
        body.classList.add('theme-switching');
        
        // Remove existing theme classes
        body.classList.remove('dark-scheme', 'light-scheme', 'auto-scheme');
        
        // Apply new theme
        switch (theme) {
            case 'dark':
                body.classList.add('dark-scheme');
                break;
            case 'light':
                body.classList.add('light-scheme');
                break;
            case 'auto':
                body.classList.add('auto-scheme');
                if (this.getSystemTheme() === 'dark') {
                    body.classList.add('dark-scheme');
                }
                break;
            default:
                body.classList.add('light-scheme');
        }

        // Update meta theme-color for mobile browsers
        this.updateMetaThemeColor(theme);
        
        // Remove transition class after a brief delay
        setTimeout(() => {
            body.classList.remove('theme-switching');
        }, 100);

        this.currentTheme = theme;
        this.storeTheme(theme);
        this.updateToggleButton();
    }

    updateMetaThemeColor(theme) {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');
        if (!metaThemeColor) {
            metaThemeColor = document.createElement('meta');
            metaThemeColor.name = 'theme-color';
            document.head.appendChild(metaThemeColor);
        }

        const colors = {
            light: '#ffffff',
            dark: '#121212',
            auto: this.getSystemTheme() === 'dark' ? '#121212' : '#ffffff'
        };

        metaThemeColor.content = colors[theme] || colors.light;
    }

    toggleTheme() {
        const themes = ['light', 'dark', 'auto'];
        const currentIndex = themes.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % themes.length;
        this.applyTheme(themes[nextIndex]);
    }

    createToggleButton() {
        const existingButton = document.getElementById('theme-toggle-btn');
        if (existingButton) {
            existingButton.remove();
        }

        const button = document.createElement('button');
        button.id = 'theme-toggle-btn';
        button.className = 'theme-toggle';
        button.setAttribute('aria-label', 'Toggle theme');
        button.innerHTML = `
            <i class="fa fa-sun-o sun-icon" aria-hidden="true"></i>
            <i class="fa fa-moon-o moon-icon" aria-hidden="true"></i>
        `;

        document.body.appendChild(button);
        this.updateToggleButton();
    }

    updateToggleButton() {
        const button = document.getElementById('theme-toggle-btn');
        if (!button) return;

        const tooltips = {
            light: 'Switch to dark theme',
            dark: 'Switch to auto theme',
            auto: 'Switch to light theme'
        };

        button.setAttribute('title', tooltips[this.currentTheme] || tooltips.light);
    }

    bindEvents() {
        // Toggle button click
        document.addEventListener('click', (e) => {
            if (e.target.closest('#theme-toggle-btn')) {
                this.toggleTheme();
            }
        });

        // Keyboard shortcut (Ctrl/Cmd + Shift + D)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'D') {
                e.preventDefault();
                this.toggleTheme();
            }
        });

        // System theme change detection
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (this.currentTheme === 'auto') {
                    this.applyTheme('auto');
                }
            });
        }

        // Storage event for sync across tabs
        window.addEventListener('storage', (e) => {
            if (e.key === 'caravel-theme' && e.newValue !== this.currentTheme) {
                this.applyTheme(e.newValue);
            }
        });
    }

    // Public API methods
    setTheme(theme) {
        if (['light', 'dark', 'auto'].includes(theme)) {
            this.applyTheme(theme);
        }
    }

    getTheme() {
        return this.currentTheme;
    }

    isDarkMode() {
        return document.body.classList.contains('dark-scheme');
    }

    // Create theme selector widget
    createThemeSelector(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const selector = document.createElement('div');
        selector.className = 'theme-selector';
        selector.innerHTML = `
            <div class="theme-option" data-theme="light">
                <i class="fa fa-sun-o"></i> Light
            </div>
            <div class="theme-option" data-theme="dark">
                <i class="fa fa-moon-o"></i> Dark
            </div>
            <div class="theme-option" data-theme="auto">
                <i class="fa fa-adjust"></i> Auto
            </div>
        `;

        container.appendChild(selector);

        // Update active state
        const updateActiveState = () => {
            selector.querySelectorAll('.theme-option').forEach(option => {
                option.classList.toggle('active', option.dataset.theme === this.currentTheme);
            });
        };

        updateActiveState();

        // Bind click events
        selector.addEventListener('click', (e) => {
            const option = e.target.closest('.theme-option');
            if (option) {
                this.applyTheme(option.dataset.theme);
                updateActiveState();
            }
        });
    }
}

// Initialize theme manager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Utility functions for manual initialization
window.CaravelTheme = {
    init: () => {
        if (!window.themeManager) {
            window.themeManager = new ThemeManager();
        }
    },
    setTheme: (theme) => {
        if (window.themeManager) {
            window.themeManager.setTheme(theme);
        }
    },
    getTheme: () => {
        return window.themeManager ? window.themeManager.getTheme() : 'light';
    },
    toggleTheme: () => {
        if (window.themeManager) {
            window.themeManager.toggleTheme();
        }
    },
    isDarkMode: () => {
        return window.themeManager ? window.themeManager.isDarkMode() : false;
    }
};

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeManager;
}