<template>
    <div class="auth">
        <div class="auth-card card">
            <div class="brand">
                <span class="brand-mark">T</span>
                <span class="brand-name">TPS</span>
            </div>
            <h1>Welcome back</h1>
            <p class="sub">Sign in to your account to continue.</p>

            <p v-if="error" class="error">{{ error }}</p>

            <form @submit.prevent="submit" class="form">
                <label class="field">
                    <span>Username</span>
                    <input v-model="form.username" class="input" type="text" autocomplete="username" required />
                </label>
                <label class="field">
                    <span>Password</span>
                    <input v-model="form.password" class="input" type="password" autocomplete="current-password" required />
                </label>
                <button class="btn btn-primary submit" :disabled="loading" type="submit">
                    {{ loading ? 'Signing in…' : 'Sign in' }}
                </button>
            </form>

            <button class="theme-toggle btn btn-ghost" @click="theme.toggle()">
                {{ theme.isDark ? '☀ Light mode' : '☾ Dark mode' }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useThemeStore } from '../stores/theme';

const auth = useAuthStore();
const theme = useThemeStore();
const router = useRouter();
const form = reactive({ username: '', password: '' });
const error = ref('');
const loading = ref(false);

async function submit() {
    error.value = '';
    loading.value = true;
    try {
        await auth.login(form);
        router.push({ name: 'dashboard' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Invalid credentials.';
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
.auth { min-height: 100vh; display: grid; place-items: center; padding: 1rem;
    background: radial-gradient(1200px 600px at 50% -10%, var(--primary-soft), var(--bg) 60%); }
.auth-card { width: 380px; max-width: 100%; padding: 2rem; }
.brand { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.5rem; }
.brand-mark { width: 36px; height: 36px; display: grid; place-items: center; background: var(--primary); color: #fff; border-radius: 10px; font-weight: 700; }
.brand-name { font-size: 1.2rem; font-weight: 700; }
h1 { font-size: 1.4rem; }
.sub { color: var(--text-muted); margin: 0.35rem 0 1.5rem; }
.form { display: flex; flex-direction: column; gap: 1rem; }
.field { display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.82rem; font-weight: 550; color: var(--text-muted); }
.submit { width: 100%; padding: 0.65rem; margin-top: 0.3rem; }
.error { color: var(--danger); background: var(--danger-soft); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm); margin: 0 0 1rem; }
.theme-toggle { width: 100%; margin-top: 1.25rem; }
</style>
