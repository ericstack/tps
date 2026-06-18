<template>
    <div class="cp">
        <div class="cp-card card">
            <h1>{{ forced ? 'Set a new password' : 'Change password' }}</h1>
            <p v-if="forced" class="sub">
                Your account uses a temporary password. Choose a new one to continue.
            </p>
            <p v-else class="sub">Update the password for your account.</p>

            <p v-if="error" class="error">{{ error }}</p>
            <p v-if="success" class="success">Password updated.</p>

            <form class="form" @submit.prevent="submit">
                <label v-if="!forced" class="field">
                    <span>Current password</span>
                    <input v-model="form.current_password" class="input" type="password" autocomplete="current-password" required />
                </label>
                <label class="field">
                    <span>New password</span>
                    <input v-model="form.new_password" class="input" type="password" autocomplete="new-password" required />
                </label>
                <label class="field">
                    <span>Confirm new password</span>
                    <input v-model="form.new_password_confirmation" class="input" type="password" autocomplete="new-password" required />
                </label>
                <button class="btn btn-primary submit" :disabled="loading" type="submit">
                    {{ loading ? 'Saving…' : 'Update password' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const router = useRouter();

const forced = computed(() => auth.mustChangePassword);

const form = reactive({ current_password: '', new_password: '', new_password_confirmation: '' });
const error = ref('');
const success = ref(false);
const loading = ref(false);

async function submit() {
    error.value = '';
    success.value = false;
    loading.value = true;
    try {
        await auth.changePassword({ ...form });
        success.value = true;
        // Forced users land on the dashboard; others return to their profile.
        router.push({ name: forced.value ? 'dashboard' : 'profile' });
    } catch (e) {
        const errors = e.response?.data?.errors;
        error.value = errors ? Object.values(errors)[0][0] : e.response?.data?.message || 'Could not update password.';
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
.cp { display: grid; place-items: center; padding: 2rem 1rem; }
.cp-card { width: 420px; max-width: 100%; padding: 2rem; }
h1 { font-size: 1.4rem; margin: 0; }
.sub { color: var(--text-muted); margin: 0.35rem 0 1.5rem; }
.form { display: flex; flex-direction: column; gap: 1rem; }
.field { display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.82rem; font-weight: 550; color: var(--text-muted); }
.submit { width: 100%; padding: 0.65rem; margin-top: 0.3rem; }
.error { color: var(--danger); background: var(--danger-soft); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm); margin: 0 0 1rem; }
.success { color: var(--success, #16a34a); padding: 0 0 0.5rem; margin: 0; }
</style>
