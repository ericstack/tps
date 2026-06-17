import { defineStore } from 'pinia';

const STORAGE_KEY = 'tps-theme';

function preferredTheme() {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved === 'light' || saved === 'dark') return saved;
    return window.matchMedia?.('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

export const useThemeStore = defineStore('theme', {
    state: () => ({ theme: 'light' }),
    getters: {
        isDark: (state) => state.theme === 'dark',
    },
    actions: {
        apply() {
            document.documentElement.setAttribute('data-theme', this.theme);
        },
        init() {
            this.theme = preferredTheme();
            this.apply();
        },
        toggle() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem(STORAGE_KEY, this.theme);
            this.apply();
        },
    },
});
