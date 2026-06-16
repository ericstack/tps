import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.user,
        isAdmin: (state) => state.user?.access === 1,
    },
    actions: {
        // Sanctum requires the CSRF cookie before the first stateful POST.
        async login(credentials) {
            await window.axios.get('/sanctum/csrf-cookie');
            const { data } = await window.axios.post('/api/login', credentials);
            this.user = data.user;
            return this.user;
        },
        async fetchUser() {
            try {
                const { data } = await window.axios.get('/api/user');
                this.user = data.user;
            } catch {
                this.user = null;
            }
            return this.user;
        },
        async logout() {
            await window.axios.post('/api/logout');
            this.user = null;
        },
    },
});
