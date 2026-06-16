<template>
    <div class="login-wrap">
        <form class="login-box" @submit.prevent="submit">
            <h1>TPS Login</h1>
            <p v-if="error" class="error">{{ error }}</p>
            <input v-model="form.username" type="text" placeholder="Username" required />
            <input v-model="form.password" type="password" placeholder="Password" required />
            <button :disabled="loading" type="submit">{{ loading ? 'Signing in…' : 'Sign In' }}</button>
        </form>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
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
        error.value = e.response?.data?.message || 'Login failed.';
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
.login-wrap { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #d2d6de; font-family: system-ui, sans-serif; }
.login-box { background: #fff; padding: 2rem; border-radius: 6px; width: 320px; display: flex; flex-direction: column; gap: .75rem; }
.login-box input { padding: .6rem; border: 1px solid #ccc; border-radius: 4px; }
.login-box button { padding: .6rem; background: #367fa9; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
.error { color: #dd4b39; margin: 0; }
</style>
