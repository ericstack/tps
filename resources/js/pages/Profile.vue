<template>
    <div class="profile">
        <div class="hero card">
            <span class="avatar">{{ initials }}</span>
            <div>
                <h2>{{ auth.user?.name }}</h2>
                <p class="muted">@{{ auth.user?.username }}</p>
                <span class="badge badge-primary">{{ auth.isAdmin ? 'Administrator' : 'User' }}</span>
            </div>
        </div>

        <div class="grid">
            <div class="card info">
                <h3>Account details</h3>
                <dl>
                    <div><dt>Name</dt><dd>{{ auth.user?.name }}</dd></div>
                    <div><dt>Username</dt><dd>{{ auth.user?.username }}</dd></div>
                    <div><dt>Role</dt><dd>{{ auth.isAdmin ? 'Administrator (access 1)' : 'User (access 2)' }}</dd></div>
                    <div><dt>Status</dt><dd>{{ auth.user?.active ? 'Active' : 'Inactive' }}</dd></div>
                    <div><dt>Member since</dt><dd>{{ created }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const initials = computed(() => {
    const n = auth.user?.name || auth.user?.username || '?';
    return n.split(' ').map((p) => p[0]).slice(0, 2).join('').toUpperCase();
});
const created = computed(() => {
    const d = auth.user?.created_at;
    return d ? new Date(d).toLocaleDateString() : '—';
});
</script>

<style scoped>
.profile { display: flex; flex-direction: column; gap: 1.25rem; max-width: 720px; }
.hero { display: flex; align-items: center; gap: 1.25rem; padding: 1.5rem; }
.avatar { width: 72px; height: 72px; border-radius: 50%; display: grid; place-items: center; background: var(--primary); color: #fff; font-size: 1.5rem; font-weight: 700; }
h2 { font-size: 1.3rem; }
.muted { color: var(--text-muted); margin: 0.2rem 0 0.6rem; }
.info { padding: 1.5rem; }
.info h3 { margin-bottom: 1rem; }
dl { margin: 0; display: flex; flex-direction: column; gap: 0.75rem; }
dl > div { display: flex; justify-content: space-between; gap: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border); }
dl > div:last-child { border-bottom: none; padding-bottom: 0; }
dt { color: var(--text-muted); }
dd { margin: 0; font-weight: 550; text-align: right; }
</style>
