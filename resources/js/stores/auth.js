import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.user,
        role: (state) => state.user?.role,
        isAdmin: (state) => state.user?.role === 'admin',
        mustChangePassword: (state) => !!state.user?.must_change_password,
        // Uses the server-resolved module list on the user payload, so the
        // role → module map lives only on the backend (config/roles.php).
        can: (state) => (module) =>
            state.user?.role === 'admin' || (state.user?.modules || []).includes(module),
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
        async changePassword(payload) {
            const { data } = await window.axios.post('/api/change-password', payload);
            this.user = data.user;
            return this.user;
        },
        async logout() {
            await window.axios.post('/api/logout');
            this.user = null;
        },
    },
});
